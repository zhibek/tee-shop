<?php
class CamelCase_Weather_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getConfigCity()
    {
        return Mage::getStoreConfig('general/camelcase_weather/city');
    }

}