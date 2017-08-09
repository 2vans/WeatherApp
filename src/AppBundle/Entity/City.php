<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity;
 * @ORM\Table(name="Weather_Info")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 * @UniqueEntity("city")
 */
class City implements \Serializable
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $cond;

    /**
     * @ORM\Column(type="integer")
     */
    private $temp;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCond()
    {
        return $this->cond;
    }

    /**
     * @param mixed $cond
     */
    public function setCond($cond)
    {
        $this->cond = $cond;
    }

    /**
     * @return mixed
     */
    public function getTemp()
    {
        return $this->temp;
    }

    /**
     * @param mixed $temp
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->city,
            $this->cond,
            $this->latitude,
            $this->longitude
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->city,
            $this->cond,
            $this->latitude,
            $this->longitude
            ) = unserialize($serialized);
    }


}