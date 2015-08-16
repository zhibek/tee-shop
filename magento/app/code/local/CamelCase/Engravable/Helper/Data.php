<?php
class CamelCase_Engravable_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getConfigCharacterCost()
    {
        return Mage::getStoreConfig('general/camelcase_engravable/character_cost');
    }

}