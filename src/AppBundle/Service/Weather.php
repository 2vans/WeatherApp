<?php

namespace AppBundle\Service;

use AppBundle\Entity\City;

class Weather
{

    private $baseUrl;
    private $baseYql;

    /**
     * Weather constructor.
     * @param array $apiUrls
     * @internal param $baseUrl
     */
    public function __construct(array $apiUrls)
    {
        $this->baseUrl = $apiUrls['base.url'];
        $this->baseYql = $apiUrls['base.yql'];
    }

    /**
     * @param City $city
     * @return City
     * @internal param string $whichCity
     */
    public function getWeather(City $city)
    {
        $apiResponse = $this->getJson($city->getLatitude(), $city->getLongitude());
        $this->setWeatherCondition($city, $apiResponse);

        return $city;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return mixed
     */
    private function getJson($latitude, $longitude)
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
    private function setWeatherCondition(City $city, $apiResponse)
    {
        if ($apiResponse == null) {
            dump('No Weather Service Available, giving database data');
            return;
        }

        $response = $apiResponse->query->results->channel;
        $city->setTemp($response->item->condition->temp);
        $city->setCond($response->item->condition->text);
    }
}