<?php

class CamelCase_Weather_Block_Weather extends Mage_Core_Block_Template
{
    public function getWeather()
    {
        /* @var $model CamelCase_Weather_Model_Weather */
        $model = Mage::getModel("camelcase_weather/weather");
        
        return $model->getWeatherData();
    }
    
}
