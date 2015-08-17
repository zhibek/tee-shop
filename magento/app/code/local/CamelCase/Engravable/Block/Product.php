<?php
class CamelCase_Engravable_Block_Product extends Mage_Catalog_Block_Product_Abstract
{

    public function isEngravableProduct()
    {
        return (bool)$this->getProduct()->getIsEngravable();
    }

}