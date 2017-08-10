<?php

namespace AppBundle\Controller\Json;

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
        $weather = $this->get('app.weather');
        $city = $weather->getCityByName($cityName);
        $currentWeather = $weather->getCurrentWeatherFromApi($city);
        $weather->updateCityToDatabase($currentWeather);

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
