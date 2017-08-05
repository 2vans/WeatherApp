<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RefreshWeatherController extends Controller
{
    /**
     * @Route("/city/{mainCity}/weather", name="refreshWeather")
     * @Method("GET")
     * @param $mainCity
     * @return JsonResponse
     */
    public function refreshWeatherAction($mainCity)
    {

        $weatherDatabase = $this->get('app.weather_database');
        $city = $weatherDatabase->getByName($mainCity);
        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($city);
        $weatherDatabase->update($currentWeather);

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
