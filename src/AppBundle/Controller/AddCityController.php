<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\CityType;

class AddCityController extends Controller
{

    /**
     * @Route("/add/city", name="add_city")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newCityAction(Request $request)
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $city = $form->getData();
            $weatherDatabase = $this->get('app.weather');
            $weatherDatabase->writeCityToDatabase($city);

            return $this->redirectToRoute('weather_app', ['cityName' => $city->getCity()]);
        }

        return $this->render('app/add_city.html.twig', ['form' => $form->createView()]);
    }
}
