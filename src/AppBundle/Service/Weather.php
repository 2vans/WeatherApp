<?php
    namespace AppBundle\Service;
    use AppBundle\Entity\WeatherInfo;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

    class Weather {

        /**
         * @param WeatherInfo $city
         * @return WeatherInfo
         * @internal param string $whichCity
         */



        public function getWeather(WeatherInfo $city)
        {
            $latitude = $city->getLatitude();
            $longitude = $city->getLongitude();

            $BASE_URL = "http://query.yahooapis.com/v1/public/yql"; // do parametrow
            $yql_query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='($latitude,$longitude)')";
            $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
            // Make call with cURL
            $session = curl_init($yql_query_url);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($session);
            // Convert JSON to PHP object
            $phpObj = json_decode($json);


            if ($phpObj == null) {
                dump('No Weather Service Available, giving database data');
                return $city;
            }

            $response = $phpObj->query->results->channel;

            $city->setTemp($response->item->condition->temp);
            $city->setCond($response->item->condition->text);


            return $city;

        }
    }