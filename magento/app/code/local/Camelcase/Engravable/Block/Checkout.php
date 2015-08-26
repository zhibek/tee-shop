<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class CamelCase_Engravable_Block_Checkout extends Mage_Core_Block_Template {
    
    public function getName(){ 
        return $this->getParentBlock()->getItem()->getData()['engraved_name'];
    }
    public function getDate(){
        return $this->getParentBlock()->getItem()->getData()['engraved_date'];
    }
}
