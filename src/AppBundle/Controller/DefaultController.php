<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="WeatherApp")
     */
    public function indexAction(Request $request)
    {
    /*
        $this->add('isAttending', ChoiceType::class, array(
            'choices'  => array(
                'Maybe' => null,
                'Yes' => true,
                'No' => false,
            ),
        ));
*/



        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="warsaw")';
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
        // Make call with cURL
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        // Convert JSON to PHP object
        $phpObj =  json_decode($json);

        $city = $phpObj->query->results->channel->location->city;
        $country = $phpObj->query->results->channel->location->country;
        $temp = $phpObj->query->results->channel->item->condition->temp;
        $condition = $phpObj->query->results->channel->location->country;

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array('city' => $city, 'country' =>$country, 'temp' => $temp, 'condition' => $condition));
    }
}
