<?php
class CamelCase_Weather_Block_Weather extends Mage_Core_Block_Template
{

    private $client;

    public function getTemp()
    {
        if (!$this->client) {
            $this->client = Mage::getModel('camelcase_weather/client');
        }
        
        return $this->client->getTemp();
    }

    public function getConditions()
    {
        if (!$this->client) {
            $this->client = Mage::getModel('camelcase_weather/client');
        }
        
        return $this->client->getConditions();
    }

}