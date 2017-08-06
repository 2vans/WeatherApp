<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class Security
{

    private $container;

    /**
     * Security constructor.
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param User $user
     * @param $password
     */
    public function login(User $user, $password)
    {
        $token = new UsernamePasswordToken(
            $user,
            $password,
            'main',
            $user->getRoles()
        );

        $this->container->get('security.token_storage')->setToken($token);
        $this->container->get('session')->set('_security_main', serialize($token));
    }
}