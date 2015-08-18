<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Camelcase_Weather_Block_Weather extends Mage_Core_Block_Template {

    public function getTemp() {
//         call model to fetch data
        $temp = Mage::getModel("weather/weather")->getTemp();
        return $temp;
    }

    public function getCity() {
//         call model to fetch data
        $city = Mage::getModel("weather/weather")->getCity();
        return $city;
    }

}
