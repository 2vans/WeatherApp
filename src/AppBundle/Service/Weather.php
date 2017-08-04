<?php

namespace AppBundle\Service;

use AppBundle\Entity\WeatherInfo;

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
     * @param WeatherInfo $city
     * @return WeatherInfo
     * @internal param string $whichCity
     */
    public function getWeather(WeatherInfo $city)
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
        // Convert JSON to PHP object
        $phpObj = json_decode($json);

        return $phpObj;

    }

    /**
     * @param WeatherInfo $city
     * @param $apiResponse
     */
    private function setWeatherCondition(WeatherInfo $city, $apiResponse)
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