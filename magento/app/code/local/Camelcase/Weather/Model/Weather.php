<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Camelcase_Weather_Model_Weather extends Mage_Core_Model_Abstract {

    private function getWeatherInfo() {

        $client = new Zend_Http_Client('http://api.openweathermap.org/data/2.5/weather?q=Cairo');
        $body = $client->request()->getBody();
        $Json = json_decode($body, true);
        return $Json;
    }

    public function getTemp() {
        $weather = $this->getWeatherInfo();
        return $weather["main"]["temp"]-272.15;
    }

    public function getCity() {
        $weather = $this->getWeatherInfo();
        return $weather["name"];
    }
}
