<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{

    /**
     * @Route("{cityName}", name="weather_app")
     * @param $cityName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($cityName = 'Warsaw, Poland')
    {
        $weather = $this->get('app.weather');
        $city = $weather->getCityByName($cityName);
        $city = $weather->getCurrentWeatherFromApi($city);

        $weather->updateCityToDatabase($city);
        $cityList = $weather->getListOfAllCities();

        return $this->render('app/index.html.twig', [
            'currentWeather' => $city,
            'cityList' => $cityList,
        ]);
    }
}
