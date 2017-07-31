<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.07.17
 * Time: 13:02
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity;
 * @ORM\Table(name="Weather_Info")
 */


class WeatherInfo
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string")
     */

    private $city;


    /**
     * @ORM\Column(type="string")
     */

    private $country;


    /**
     * @ORM\Column(type="string")
     */

    private $cond;


    /**
     * @ORM\Column(type="integer")
     */

    private $temp;

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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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



}