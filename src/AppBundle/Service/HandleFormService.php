<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class HandleFormService
{
    private $container;

    /**
     * HandleFormService constructor.
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param User $user
     */
    public function handleRegisterForm(User $user)
    {
        $password = $this->container
            ->get('security.password_encoder')
            ->encodePassword(
                $user,
                $user->getPlainPassword()
            );

        $user->setPassword($password);
        $em = $this->container->get("doctrine")->getManager();;
        $em->persist($user);
        $em->flush();
    }

    /**
     * @param User $user
     */
    public function loginUserAfterRegistration(User $user)
    {
        $token = new UsernamePasswordToken(
            $user->getUsername(),
            $user->getPassword(),
            'main',
            $user->getRoles()
        );

        $this->container->get('security.token_storage')->setToken($token);
        $this->container->get('session')->set('_security_main', serialize($token));
    }
}