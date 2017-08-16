<?php

namespace AppBundle\Security\User;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface, EquatableInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;

    /**
     * SecurityUser constructor.
     * @param User|UserInterface $user
     * @internal param $username
     * @internal param $password
     * @internal param $salt
     * @internal param $roles
     */
    public function __construct(User $user)
    {
        $this->username = $user->getUsername();
        $this->password = $user->getPassword();
        $this->salt = $user->getSalt();
        $this->roles = $user->getRoles();
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if(!$user instanceof UserInterface) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     *  Do not erase credentials for SecurityUser!
     */
    public function eraseCredentials()
    {
        // It should remain empty
    }


}