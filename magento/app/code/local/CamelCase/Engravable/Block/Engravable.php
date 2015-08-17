<?php

class CamelCase_Engravable_Block_Engravable extends Mage_Core_Block_Template
{
    public function getProduct() {
         /* @var $model CamelCase_Engravable_Model_Engravable */
        $model = Mage::getModel('camelcase_engravable/engravable');
        
        return $model->getProduct();
    }
    
}