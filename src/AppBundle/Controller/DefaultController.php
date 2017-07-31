<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\WeatherInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Service\Weather;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class DefaultController extends Controller
{


    /**
     * @Route("/test", name="TestWeatherApp")
     */

    public function testAction() {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonWeather = new WeatherInfo();
        $jsonWeather->setCity('Miasto');
        $jsonWeather->setCountry('Panstwo');
        $jsonWeather->setTemp('99');
        $jsonWeather->setCondition('chmury');


        $jsonContent = $serializer->serialize($jsonWeather, 'json');

        $cnx = $this->getDoctrine()->getConnection();



        if(    $cnx->isConnected()) {
            dump('polaczone');
        }   else {
            dump('niepolaczone');
        }



        return $this->render('default/test.html.twig', ['content' => $jsonContent]
        );
    }

    /**
     * @Route("/new", name="newCity")
     */

    public function newAtcion() {
        $weatherInfo = new WeatherInfo();

        $weatherInfo->setTemp(33);
        $weatherInfo->setCond('cloudy');
        $weatherInfo->setCountry('Poland');
        $weatherInfo->setCity('warsaw');
        $dbConect = $this->getDoctrine()->getManager();
        $dbConect->persist($weatherInfo);
        $dbConect->flush();


        $query = $dbConect->getRepository('AppBundle:WeatherInfo')->findAll();

        dump($query);

        return $this->render('default/phpinfo.html.twig', ['allWeater' => $query]);

    }


    /**
     * @Route("/sky/{mainCity}", name="WeatherApp")
     */
    public function indexAction($mainCity = 'Warszawa')
    {

        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($mainCity);

        $weatherInfo->setTemp(33);
        $weatherInfo->setCond('cloudy');
        $weatherInfo->setCountry('Poland');
        $weatherInfo->setCity('warsaw');

        $dbConect = $this->getDoctrine()->getManager();
        $query = $dbConect->getRepository('AppBundle:WeatherInfo')->findAll();

        dump($query);




        return $this->render('default/index.html.twig', ['currentWeather' =>$currentWeather, 'dbWeather' => $query
            ]);
    }




}
