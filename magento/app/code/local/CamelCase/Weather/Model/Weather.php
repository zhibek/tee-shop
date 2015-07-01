<?php

class CamelCase_Weather_Model_Weather extends Mage_Core_Model_Abstract
{
    public function getWeatherData()
    {
        $client  = new Zend_Http_Client('http://api.openweathermap.org/data/2.5/weather?q=Cairo');
        $body    = $client->request()->getBody();
        $weather = json_decode($body, true);
     
        return array(
                'temp'     => $weather['main']['temp'],
                'condition' => $weather['weather'][0]['description']
        );
    }
}
