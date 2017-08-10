<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Security\User\UserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends Controller
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
            $this->get(UserProvider::class)->loginUserAfterRegistration($user, $handleForm->getPassword());

            return $this->redirectToRoute('random_city');
        }

        return $this->render('app/registration.html.twig', [
            'registration_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/login", name="login")
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('app/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/user/logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException(sprintf('Do not use it.'));
    }
}
