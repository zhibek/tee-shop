<?php

class CamelCase_Weather_Block_Weather extends Mage_Core_Block_Template
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
    }
    
    public function getWeather()
    {
        $weatherJson = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=Cairo"));
        return $weatherJson;
    }
}