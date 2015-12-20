<?php

// app/code/local/Teeshop/Weather/Block/Weather.php
class Teeshop_Weather_Block_Weather extends Mage_Core_Block_Template {

    public function getWeather() {
        // sectionName/groupName/fieldName
        $city = Mage::getStoreConfig('weather/general/city_field');
        $filename = "http://api.openweathermap.org/data/2.5/weather?units=metric&type=accurate&mode=json&APPID=d325cad0331793fd3da96c94b5161278&q=$city";
        $weatherData = file_get_contents($filename);
        return json_decode($weatherData);
    }

}
