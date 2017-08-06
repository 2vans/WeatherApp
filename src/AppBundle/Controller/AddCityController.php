<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WeatherInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\WeatherInfoType;

class AddCityController extends Controller
{

    /**
     * @Route("/add/city", name="add_city")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newCityAction(Request $request)
    {
        $weather = new WeatherInfo();
        $form=$this->createForm(WeatherInfoType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $weather = $form->getData();
            $weatherDatabase = $this->get('app.weather_database');
            $weatherDatabase->write($weather);

            return $this->redirectToRoute('weather_app', ['cityName' => $weather->getCity()]);
        }

        return $this->render('app/add_city.html.twig', ['form' => $form->createView()]);
    }
}
