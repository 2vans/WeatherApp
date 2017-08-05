<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 04.08.17
 * Time: 16:47
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;

class HandleForms
{

    private $container;
    private $password;

    /**
     * HandleForms constructor.
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handleRegisterForm(User $user)
    {

        $password = $this->container
            ->get('security.password_encoder')
            ->encodePassword(
                $user,
                $user->getPlainPassword()
            );

        $user->setPassword($password);
        $this->password=$password;

        $em = $this->container->get("doctrine")->getManager();;


        $em->persist($user);    //pushing User object to database
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