<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{

    /**
     * @Route("{cityName}", name="weather_app")
     * @param string $cityName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($cityName = 'Warsaw, Poland')
    {
        $wd = $this->get('app.weather_database');
        $city = $wd->getByName($cityName);

        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($city);

        $wd->update($currentWeather);
        $cityList = $wd->getCityList();

        return $this->render('app/index.html.twig', [
            'currentWeather' => $currentWeather,
            'cityList' => $cityList,
        ]);
    }
}
