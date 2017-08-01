<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends Controller
{

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function loginAction(Request $request, AuthenticationUtils $authUtils) {

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();


        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

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
