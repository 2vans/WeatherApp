<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/user/register", name="register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $handleForm = $this->get('app.handle_forms');
            $handleForm->handleRegisterForm($user);
            $this->get('app.security')->login($user, $handleForm->getPassword());

            return $this->redirectToRoute('weather_app');
        }

        return $this->render('app/registration.html.twig', [
            'registration_form' => $form->createView()
        ]);
    }
}