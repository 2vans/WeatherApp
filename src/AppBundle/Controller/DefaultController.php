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

    public function registrationAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();



            return $this->redirectToRoute('WeatherApp');
        }

        return $this->render(
            'default/registration.html.twig',
            array('form' => $form->createView())
        );

    }


    /**
     * @Route("{mainCity}", name="WeatherApp")
     * @param string $mainCity
     * @return \Symfony\Component\HttpFoundation\Response
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
