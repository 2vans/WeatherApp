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
     * @Route("/add/city", name="addCity")
     */

    public function newAtcion() {




        return $this->render('default/addCity.html.twig');

    }


    /**
     * @Route("{mainCity}", name="WeatherApp")
     */
    public function indexAction($mainCity = 'Warszawa')
    {

        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($mainCity);
        dump($currentWeather);

        $weatherDatabase = $this->get('app.weather_database');
        $weatherDatabase->update($currentWeather);
        $query = $weatherDatabase->read();



        dump($query);




        return $this->render('default/index.html.twig', ['currentWeather' =>$currentWeather, 'dbWeather' => $query
            ]);
    }




}
