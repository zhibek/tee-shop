<?php

class CamelCase_Engravable_Model_Engravable extends Mage_Core_Model_Abstract
{
    public function getProduct()
    {
       return Mage::registry('current_product');    
    }
}