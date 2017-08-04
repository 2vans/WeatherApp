<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WeatherInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\WeatherInfoType;

class AddCityController extends Controller
{
    /**
     * @Route("/add/city", name="addCity")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newCityAction(Request $request)
    {

        $weather = new WeatherInfo();  //creating WeatherInfo object needed for form and Doctrine

        $form=$this->createForm(WeatherInfoType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $weather = $form->getData(); //getting data from form to object WeatherInfo
            $weatherDatabase = $this->get('app.weather_database'); //getting weather_database service to write object to database
            $weatherDatabase->write($weather); //writing object

            return $this->redirectToRoute('WeatherApp', ['mainCity' => $weather->getCity()]); //redirecting to main page
        }

        return $this->render('default/addCity.html.twig', ['form' => $form->createView()]);
    }
}
