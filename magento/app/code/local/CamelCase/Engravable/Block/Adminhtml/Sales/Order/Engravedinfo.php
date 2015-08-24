<?php

class CamelCase_Engravable_Block_Adminhtml_Sales_Order_EngravedInfo extends Mage_Adminhtml_Block_Sales_Items_Abstract
{
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

}
