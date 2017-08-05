<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class DefaultController extends Controller
{

    /**
     * @Route("{mainCity}", name="WeatherApp")
     * @param string $mainCity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($mainCity = 'Warsaw, Poland')
    {
        $weatherDatabase = $this->get('app.weather_database');
        $city = $weatherDatabase->getByName($mainCity);


        dump(json_encode($city));
        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($city);

        dump($currentWeather);

        $weatherDatabase->update($currentWeather);
        $cityList = $weatherDatabase->getCityList();

        dump($cityList);

        return $this->render('default/index.html.twig', [
            'currentWeather' => $currentWeather,
            'cityList' => $cityList,
            ]);
    }

    /**
     * @Route("/city/{mainCity}/weather", name="refreshWeather")
     * @Method("GET")
     * @param $mainCity
     * @return JsonResponse
     */
    public function refreshWeatherAction($mainCity) {

        $weatherDatabase = $this->get('app.weather_database');
        $city = $weatherDatabase->getByName($mainCity);
        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($city);
        $weatherDatabase->update($currentWeather);

        $weatherData = [
            'city' => $currentWeather->getCity(),
            'temp' => $currentWeather->getTemp(),
            'cond' => $currentWeather->getCond(),
        ];


        return $this->json($weatherData);
    }


}
