<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;

class HandleFormService
{
    private $container;
    private $password;

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
        $this->password = $password;

        $em = $this->container->get("doctrine")->getManager();;
        $em->persist($user);
        $em->flush();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

}