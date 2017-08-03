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
     * @Route("/add/city", name="addCity")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newCityAction(Request $request)
    {

        $weather = new WeatherInfo();  //creating WeatherInfo object needed for form and Doctrine
            //creating simple add City form
        $form = $this->createFormBuilder($weather)
            ->add('city', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Add City'))
            ->getForm();

            //handling request posted from addCity.html.twig view
        $form->handleRequest($request);
            //checking if everything is ok
        if ($form->isSubmitted() && $form->isValid()) {

            $weather = $form->getData(); //getting data from form to object WeatherInfo
            $weatherDatabase = $this->get('app.weather_database'); //getting weather_database service to write object to database
            $weatherDatabase->writeObject($weather); //writing object

            return $this->redirectToRoute('WeatherApp'); //redirecting to main page
        }

        return $this->render('default/addCity.html.twig', ['form' => $form->createView()]);
    }
}
