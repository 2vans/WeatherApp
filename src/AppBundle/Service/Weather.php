<?php
    namespace AppBundle\Service;
    use AppBundle\Entity\WeatherInfo;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

    class Weather {

        /**
         * @param string $whichCity
         *
         * @return array
         */



        public function getWeather($whichCity, WeatherInfo $city)
        {
            $latitude = $city->getLatitude();
            $longitude = $city->getLongitude();
            dump([$latitude, $longitude]);

            $BASE_URL = "http://query.yahooapis.com/v1/public/yql"; // do parametrow
            $yql_query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='(52.1704725,20.8118862)')";
            //$yql_query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='$whichCity')";
            $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
            // Make call with cURL
            $session = curl_init($yql_query_url);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($session);
            // Convert JSON to PHP object
            $phpObj = json_decode($json);


            if ($response = $phpObj->query->results == null) {
                throw new NotFoundHttpException('City not found');
            }

            $response = $phpObj->query->results->channel;

            $city = $response->location->city;
            $country = $response->location->country;
            $temp = $response->item->condition->temp;
            $condition = $response->item->condition->text;


            return array('city' => $city, 'country' => $country, 'temp' => $temp, 'condition' => $condition);


        }
    }