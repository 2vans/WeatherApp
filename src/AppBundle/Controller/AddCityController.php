<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WeatherInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddCityController extends Controller
{
/**
* @Route("/login", name="login")
* @param Request $request
* @return \Symfony\Component\HttpFoundation\Response
*/

    public function newAction(Request $request) {



        $weather = new WeatherInfo();



        $form = $this->createFormBuilder($weather)
            ->add('city', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Add City'))
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $weather = $form->getData();
            $weatherDatabase = $this->get('app.weather_database');
            $weatherDatabase->writeObject($weather);




            return $this->redirectToRoute('WeatherApp');
        }
}
