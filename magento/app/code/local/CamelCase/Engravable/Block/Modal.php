<?php

class CamelCase_Engravable_Block_Modal extends Mage_Catalog_Block_Product_Abstract
{
    public function isEngravable()
    {         
        return (bool) $this->getProduct()->load()->getData('is_engravable');
    }
    
}