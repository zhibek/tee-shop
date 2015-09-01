<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Camelcase_Engravable_Block_Popup extends Mage_Catalog_Block_Product_Abstract {

    public function isEngravable() {
        $productData = $this->getProduct()->getData();
        return $productData['is_engravable'];
    }

}