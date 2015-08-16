<?php
class CamelCase_Engravable_Model_Observer
{

    public function setCustomAttributes($observer)
    {
        /* @var $event Varien_Event */
        $event = $observer->getEvent();
        if (!$event instanceof Varien_Event) {
            return false;
        }

        /* @var $quoteItem Mage_Sales_Model_Quote_Item */
        $quoteItem = $event->getQuoteItem();
        if (!$quoteItem instanceof Mage_Sales_Model_Quote_Item) {
            return false;
        }

        /* @var $product Mage_Catalog_Model_Product */
        $product = $quoteItem->getProduct();
        if (!$product instanceof Mage_Catalog_Model_Product) {
            return false;
        }

        // Check if product is engravable - if not, don't proceed with our functionality
        if (!$product->getIsEngravable()) {
            return;
        }

        $engravedName = Mage::app()->getRequest()->getParam('engraved_name');
        $engravedDate = date('Y-m-d');

        Mage::log('Engravable product added to cart...');
        Mage::log(sprintf('Engraved Name: "%s"', $engravedName));
        Mage::log(sprintf('Engraved Date: "%s"', $engravedDate));

        // Persist engraved_name & engraved_date
        $quoteItem->setEngravedName($engravedName);
        $quoteItem->setEngravedDate($engravedDate);
    }

}