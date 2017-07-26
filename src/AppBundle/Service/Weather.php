<?php
    namespace AppBundle\Service;

    class Weather {

        /**
         * @param string $whichCity
         *
         * @return array
         */



        public function getWeather($whichCity)
        {
            $BASE_URL = "http://query.yahooapis.com/v1/public/yql"; // do parametrow
            $yql_query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='$whichCity')";
            $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
            // Make call with cURL
            $session = curl_init($yql_query_url);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($session);
            // Convert JSON to PHP object
            $phpObj = json_decode($json);

            $response = $phpObj->query->results->channel;

            $city = $response->location->city;
            $country = $response->location->country;
            $temp = $response->item->condition->temp;
            $condition = $response->item->condition->text;

            return array('phpObj' => $phpObj, 'city' => $city, 'country' => $country, 'temp' => $temp, 'condition' => $condition);


        }
    }