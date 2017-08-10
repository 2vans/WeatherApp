<?php


namespace AppBundle\Security\User;


use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserProvider implements UserProviderInterface
{

    private $entityManager;
    private $container;

    /**
     * UserProvider constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    /**
     * @param string $username The username
     * @return UserInterface
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $entityManager = $this->entityManager;
        $userData = $entityManager->getRepository(User::class)->loadUserByUserName($username);


        if ($userData) {
            $user = new User();
            $user->setPassword($userData->getPassword());
            $user->setUsername($userData->getUsername());

            return $user;
        }

        throw new UsernameNotFoundException(sprintf(
                'Username "%s" does not exist.', $username)
        );
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     * @throws UnsupportedUserException if the user is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }

    /**
     * @param User $user
     * @param $password
     */
    public function loginUserAfterRegistration(User $user, $password)
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