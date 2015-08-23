<?php

class CamelCase_Engravable_Block_Adminhtml_Sales_Order_EngravedInfo extends Mage_Adminhtml_Block_Sales_Items_Abstract
{
    protected $item;
    
    public function setItem($item)
    {
        $this->item = $item;
    }
    
    public function getItem()
    {
        return $this->item;
    }
    
    public function __construct(array $args = array())
    {
        parent::__construct($args);
    }
    
    
    public function __call($method, $args)
    {
        Mage::log($method);
    }
}