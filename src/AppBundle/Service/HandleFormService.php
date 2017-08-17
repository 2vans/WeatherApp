<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class HandleFormService
{
    private $entityManager;
    private $encoder;
    private $tokenStorage;
    private $session;

    /**
     * HandleFormService constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $encoder,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session
    )
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * @param User $user
     */
    public function handleRegisterForm(User $user)
    {
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
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

        $this->tokenStorage->setToken($token);
        $this->session->set('_security_main', serialize($token));
    }
}