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

    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $currentWeather
     * @return mixed
     */
    public function write(array $currentWeather) {
        $weatherInfo = new WeatherInfo();
        $weatherInfo->setTemp($currentWeather['temp']);
        $weatherInfo->setCond($currentWeather['condition']);
        $weatherInfo->setCountry($currentWeather['country']);
        $weatherInfo->setCity($currentWeather['city']);



        $entityManager = $this->entityManager;
        dump($entityManager->getRepository('AppBundle:WeatherInfo'));
        $entityManager->persist($weatherInfo);
        $entityManager->flush();





        return null;

    }

    public function writeObject(WeatherInfo $currentWeather) {
        if($currentWeather->getCity() == null) {
            die;
        }
        if ($currentWeather->getCond() == null) {
            $currentWeather->setCond('unknown');
        }
        if ($currentWeather->getTemp() == null) {
            $currentWeather->setTemp(0);
        }
        if ($currentWeather->getCountry() == null) {
            $currentWeather->setCountry('unknown');
        }




        $entityManager = $this->entityManager;
        dump($entityManager->getRepository('AppBundle:WeatherInfo'));
        $entityManager->persist($currentWeather);
        $entityManager->flush();
    }

    public function read() {
        $entityManager = $this->entityManager;
        $query = $entityManager->getRepository('AppBundle:WeatherInfo')->findAll();
        return $query;
    }

    public function update(array $currentWeather) {
        $entityManager = $this->entityManager;
        $currentCity = $entityManager->getRepository(WeatherInfo::class)->findOneBy(['city' => $currentWeather['city']]);

        if (!$currentCity) {
            throw new NotFoundHttpException('City not found');
        }





        $currentCity->setTemp($currentWeather['city']);
        $currentCity->setCond($currentWeather['condition']);
        $currentCity->setTemp($currentWeather['temp']);
        $currentCity->setCountry($currentWeather['country']);


        $entityManager->flush();


    }
}