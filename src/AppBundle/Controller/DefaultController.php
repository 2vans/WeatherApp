<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DefaultController extends Controller
{
    /**
     * @Route("/{mainCity}", name="WeatherApp")
     */
    public function indexAction($mainCity = 'warsaw')
    {




        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='$mainCity')";
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
        // Make call with cURL
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        // Convert JSON to PHP object
        $phpObj =  json_decode($json);

        $response = $phpObj->query->results->channel;

        $city = $response->location->city;
        $country = $response->location->country;
        $temp = $response->item->condition->temp;
        $condition = $response->item->condition->text;

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig',
            array('phpObj' => $phpObj ,'city' => $city, 'country' =>$country, 'temp' => $temp, 'condition' => $condition));
    }
}
