<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RefreshWeatherController extends Controller
{
    /**
     * @Route("/city/{cityName}/weather", name="refresh_weather")
     * @Method("GET")
     * @param $cityName
     * @return JsonResponse
     */
    public function refreshWeatherAction($cityName)
    {

        $wd = $this->get('app.weather_database');
        $city = $wd->getByName($cityName);
        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($city);
        $wd->update($currentWeather);

        $notes = [
            [
                'id' => 1,
                'city' => $currentWeather->getCity(),
                'temp' => $currentWeather->getTemp(),
                'cond' => $currentWeather->getCond(),
            ]
        ];
        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}
