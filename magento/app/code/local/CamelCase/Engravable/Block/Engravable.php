<?php
class CamelCase_Engravable_Block_Engravable extends Mage_Catalog_Block_Product_Abstract
{

    public function isEngravableProduct()
    {
        return (bool)$this->getProduct()->getIsEngravable();
    }

}