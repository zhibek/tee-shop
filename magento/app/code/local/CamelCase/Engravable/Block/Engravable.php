<?php

class CamelCase_Engravable_Block_Engravable extends Mage_Core_Block_Template
{
    public function getProduct() {
         /* @var $model CamelCase_Engravable_Model_Engravable */
        $model = Mage::getModel('camelcase_engravable/engravable');
        
        return $model->getProduct();
    }
    
    public function getEngravedData() {
     
        $item = $this->getParentBlock()->getItem();
        $engravedName = $item->getEngravedName();
        if(!empty($engravedName)) {
            return array(
              'engraved_name' =>  $engravedName, 
              'engraved_date' =>  $item->getEngravedDate()
                    
            );
        }
        
        return FALSE;
    }
    
}