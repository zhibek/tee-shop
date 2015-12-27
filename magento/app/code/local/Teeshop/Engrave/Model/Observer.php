<?php

class Teeshop_Engrave_Model_Observer
{
    public function listenCartAdd() {
 
        $product = Mage::getModel('catalog/product')
                        ->load(Mage::app()->getRequest()->getParam('product', 0));
 
        
        if (!$product->getId()) {
            return;
        }
        $isEngravable = (bool)$product->getIsEngravable();
        if( $isEngravable === true){
            $requestParameters = Mage::app()->getRequest()->getParams();
            if(array_key_exists('engraved_name' ,$requestParameters)){
                $engravedName = $requestParameters['engraved_name'];
                Mage::log("new_product_with_engrave: $engravedName ,on: ".date(/*$format =*/ DATE_ATOM), /*$level =*/Zend_Log::INFO);
            }
        }
        
    }
    
}
