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
     * @param string $mainCity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($mainCity = 'warszawa')
    {

        $weatherService = new Weather();
        $currentWeather = $weatherService->getWeather($mainCity);



        return $this->render('default/index.html.twig', $currentWeather
            );
    }
}
