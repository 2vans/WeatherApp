<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Service\Weather;

class DefaultController extends Controller
{
    /**
     * @Route("/{mainCity}", name="WeatherApp")
     */
    public function indexAction($mainCity = 'warszawa')
    {

        $weatherService = $this->get('app.weather');
        $currentWeather = $weatherService->getWeather($mainCity);




        return $this->render('default/index.html.twig', $currentWeather
            );
    }
}
