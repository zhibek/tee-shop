<?php

class TeeShop_Search_Model_Layer extends Mage_CatalogSearch_Model_Layer
{
    
    /**
     * Get current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Resource_Product_Collection
     */
    public function getProductCollection()
    {   
        $helper = Mage::helper('teeshop_catalog');
        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        }
        else {
            // collection of all products
            $collection = Mage::getResourceModel('catalogsearch/fulltext_collection');

            // simple products only
            $simplesCollection = $helper->getSimplesOnly($collection);

            // ids for the right prouct results
            $ids = $helper->prepareColourFilteredIds($simplesCollection);

            // new collection of result products
            $collection = Mage::getResourceModel('catalogsearch/fulltext_collection')
                    ->addAttributeToFilter('entity_id', $ids);

            $this->prepareProductCollection($collection);
            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }


        return $collection;
    }

}
