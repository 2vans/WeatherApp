<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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

        dump($city);

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




}
