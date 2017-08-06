<?php

namespace AppBundle\Service;

use AppBundle\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherDatabase
{

    private $entityManager;

    /**
     * WeatherDatabase constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param City $city
     */
    public function write(City $city)
    {
        $city->setCond('unknown');
        $city->setTemp(0);

        $entityManager = $this->entityManager;
        $entityManager->persist($city);
        $entityManager->flush();
    }

    /**
     * @param City $city
     */
    public function update(City $city)
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($city);
        $entityManager->flush();
    }

    /**
     * @param $cityName
     * @return City|null|object
     */
    public function getByName($cityName)
    {
        $entityManager = $this->entityManager;
        $city = $entityManager->getRepository(City::class)->findOneBy(['city' => $cityName]);

        if (!$city) {
            throw new NotFoundHttpException('City not found');
        }

        return $city;
    }

    /**
     * @return City[]|array
     */
    public function getCityList()
    {
        $entityManager = $this->entityManager;
        $cityList = $entityManager->getRepository('AppBundle:City')->findAll();

        return $cityList;
    }


}