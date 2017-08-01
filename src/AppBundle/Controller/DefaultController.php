<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\WeatherInfo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Service\Weather;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class DefaultController extends Controller
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





        return $this->render('default/login.html.twig', ['form' => $form->createView()]);

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
