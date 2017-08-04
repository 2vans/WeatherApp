<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 31.07.17
 * Time: 13:48
 */

namespace AppBundle\Service;


use AppBundle\Entity\WeatherInfo;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\DoctrineAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherDatabase


{
    /**
     * @var EntityManagerInterface
     */

    private $entityManager;


    /**
     * WeatherDatabase constructor.
     * @param EntityManagerInterface $entityManager
     */

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function write(WeatherInfo $city)
    {
        $city->setCond('unknown');
        $city->setTemp(0);

        $entityManager = $this->entityManager;
        $entityManager->persist($city);
        $entityManager->flush();
    }

    public function update(WeatherInfo $city)
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($city);
        $entityManager->flush();

    }

    public function getByName($city)
    {
        $entityManager = $this->entityManager;
        $currentCity = $entityManager->getRepository(WeatherInfo::class)->findOneBy(['city' => $city]);

        if (!$currentCity) {
            throw new NotFoundHttpException('City not found');
        }

        return $currentCity;

    }

    public function getCityList()
    {
        $entityManager = $this->entityManager;
        $cityList = $entityManager->getRepository('AppBundle:WeatherInfo')->findAll();
        return $cityList;
    }


}