<?php

class CamelCase_Engravable_Block_Engravable extends Mage_Catalog_Block_Product_Abstract
{

    public function isEngravable()
    {
        $productData = $this->getProduct()->getData();
        return (boolean)$productData['is_engravable'] ;
    }
}
