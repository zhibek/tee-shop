<?php

class CamelCase_Engravable_Block_Checkout_Cart_Item extends Mage_Core_Block_Template
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
    }
    
    public function getEngravedName()
    {
        return $this->getItem()->getEngravableName();
    }
    
    public function getEngravedDate()
    {
        return $this->getItem()->getEngravableDate();
    }
    
    public function getItem()
    {
        return $this->getParentBlock()->getItem();
    }
    
    public function isEngravable()
    {
        return true;
    }

}
