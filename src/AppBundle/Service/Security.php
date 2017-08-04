<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 04.08.17
 * Time: 16:37
 */

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


    public function login(User $user, $password) {


        $token = new UsernamePasswordToken(     //creating token needed for login in from data provided during registration
            $user,
            $password,
            'main',
            $user->getRoles()
        );
        //system login after registration
        $this->container->get('security.token_storage')->setToken($token);
        $this->container->get('session')->set('_security_main', serialize($token));

    }
}