<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class registrationController extends Controller
{

    /**
     * @Route("/user/register", name="register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function registerAction(Request $request)
    {
        $user = new User(); //creating user needed for form and Doctrine

        $form=$this->createForm(UserType::class, $user); // creating from from UserType form

        $form->handleRequest($request); //registration request

        if ($form->isSubmitted() && $form->isValid()) { //handling registration
            //encoding password
            $password = $this
                ->get('security.password_encoder')
                ->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
                //encoded password is saved to user
                 $user->setPassword($password);
            //boot up doctrine
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);    //pushing User object to database
            $em->flush();

            $token = new UsernamePasswordToken(     //creating token needed for login in from data provided during registration
                $user,
                $password,
                'main',
                $user->getRoles()
            );
            //system login after registration
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));


            $this->addFlash('success', 'You are now successfully registered!'); // flash information can not see it

            return $this->redirectToRoute('WeatherApp');

        }
            //rendering view with created form
        return $this->render('default/registration.html.twig', [
            'registration_form' => $form->createView()
        ] );
    }
}
