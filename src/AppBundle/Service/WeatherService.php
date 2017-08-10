<?php

namespace AppBundle\Service;

use AppBundle\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherService
{

    private $entityManager;
    private $baseUrl;
    private $baseYql;

    /**
     * WeatherService constructor.
     * @param EntityManagerInterface $entityManager
     * @param array $apiUrls
     * @internal param $baseUrl
     */
    public function __construct(EntityManagerInterface $entityManager, array $apiUrls)
    {
        $this->entityManager = $entityManager;
        $this->baseUrl = $apiUrls['base.url'];
        $this->baseYql = $apiUrls['base.yql'];
    }

    /**
     * @param City $city
     * @return City
     * @internal param string $whichCity
     */
    public function getCurrentWeatherFromApi(City $city)
    {
        $apiResponse = $this->getJsonResponseFromApi($city->getLatitude(), $city->getLongitude());
        $this->setWeatherConditionOnCurrentCity($city, $apiResponse);

        return $city;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return mixed
     */
    private function getJsonResponseFromApi($latitude, $longitude)
    {
        $yqlQuery = urlencode(sprintf('%s"(%g,%g)")',
            $this->baseYql,
            $latitude,
            $longitude
        ));

        $yqlQueryUrl = sprintf('%s?q=%s&format=json',
            $this->baseUrl,
            $yqlQuery
        );

        $session = curl_init($yqlQueryUrl);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        $phpObj = json_decode($json);

        return $phpObj;
    }

    /**
     * @param City $city
     * @param $apiResponse
     */
    private function setWeatherConditionOnCurrentCity(City $city, $apiResponse)
    {
        if ($apiResponse == null) {
            dump('No WeatherService Service Available, giving database data');
            return;
        }

        $response = $apiResponse->query->results->channel;
        $city->setTemp($response->item->condition->temp);
        $city->setCond($response->item->condition->text);
    }

    /**
     * @param City $city
     */
    public function writeCityToDatabase(City $city)
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
    public function updateCityToDatabase(City $city)
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($city);
        $entityManager->flush();
    }

    /**
     * @param $cityName
     * @return City|null|object
     */
    public function getCityByName($cityName)
    {
        $entityManager = $this->entityManager;
        $city = $entityManager->getRepository(City::class)->findOneByName($cityName);

        if (!$city) {
            throw new NotFoundHttpException(sprintf('City not found'));
        }

        return $city;
    }

    /**
     * @return City[]|array
     */
    public function getListOfAllCities()
    {
        $entityManager = $this->entityManager;
        $cityList = $entityManager->getRepository(City::class)->listOfAllCities();

        return $cityList;
    }

    /**
     * @return City|null|object
     */
    public function getRandomCityFromDatabase()
    {
        $entityManager = $this->entityManager;
        $randomCity = $entityManager->getRepository(City::class)->randomCityFromDatabase();

        return $randomCity;
    }
}