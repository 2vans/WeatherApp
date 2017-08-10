<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{

    /**
     * @Route("/", name="random_city")
     * @Route("/{city_name}", name="weather_app")
     * @param City $city
     * @ParamConverter("city", class="AppBundle:City", options={"mapping": {"city_name": "city"}})
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $cityName
     */
    public function indexAction(City $city = null)
    {
        $weather = $this->get('app.weather');
        if (!$city) {
            $city = $weather->getRandomCityFromDatabase();
        }

        $city = $weather->getCurrentWeatherFromApi($city);
        $weather->updateCityToDatabase($city);
        $cityList = $weather->getListOfAllCities();

        return $this->render('app/index.html.twig', [
            'currentWeather' => $city,
            'cityList' => $cityList,
        ]);
    }
}
