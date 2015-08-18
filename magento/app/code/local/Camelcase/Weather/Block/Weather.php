<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Camelcase_Weather_Block_Weather extends Mage_Core_Block_Template {

    private function getWeather() {
//         call model to fetch data
    $forcastInfo = Mage::getModel("weather/weather")->getWeatherInfo();
    $Json = json_decode($forcastInfo, true);
    return $Json;

    }

    public function getTemp() {
        $weather = $this->getWeather();
        return $weather["main"]["temp"];
    }

    public function getCity() {
        $weather = $this->getWeather();
        return $weather["name"];
    }

}
