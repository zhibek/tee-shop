<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TeeShop_Catalog_Model_Layer extends Mage_Catalog_Model_Layer
{
    /* @ Override 
     * This method had been overriden to edit the collection
     * for listing and forcing the rule of only showing one size
     * for each color for each size
     * 
     * @param collection of all products cutomized inside the fuction
     *  
     */

    public function prepareProductCollection($collection)
    {
        $helper = Mage::helper('teeshop_catalog');
        $ids = $helper->prepareColourFilteredIds();

        $collection
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addUrlRewrite($this->getCurrentCategory()->getId())
                ->addAttributeToFilter('entity_id', $ids)
        ;

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        return $this;
    }

    
}
