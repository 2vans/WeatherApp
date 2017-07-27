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

        $fs = new  Filesystem();
        $zmienna = 'kupa';
        dump($zmienna);
        try {
            if (!$fs->exists(__DIR__ . '/app/Resources/kupa')) {

                $fs->mkdir(__DIR__ . '/app/Resources/kupa');
            }
        } catch (IOException $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }
            try {
                $fs->dumpFile(__DIR__ . '/app/Resources/file.json', $jsonContent);
            } catch (IOException $e) {
            }


        return $this->render('default/test.html.twig', ['content' => $jsonContent]
        );
    }




    /**
     * @Route("/sky/{mainCity}", name="WeatherApp")
     */
    public function indexAction($mainCity = 'warszawa')
    {

        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($mainCity);


        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonWeather = new WeatherInfo();
        $jsonWeather->setCity('Miasto');
        $jsonWeather->setCountry('Panstwo');
        $jsonWeather->setTemp('99');
        $jsonWeather->setCondition('chmury');


        $jsonContent = $serializer->serialize($currentWeather, 'json');


        return $this->render('default/index.html.twig', $currentWeather
            );
    }




}
