<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Camelcase_Weather_Model_Weather extends Mage_Core_Model_Abstract {

    public function getWeatherInfo() {

        $client = new Zend_Http_Client('http://api.openweathermap.org/data/2.5/weather?q=Cairo');
        $body = $client->request()->getBody();
        return $body;
    }

}
