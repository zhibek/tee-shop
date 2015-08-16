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

        // Calculate new product cost and persist to quote
        $cost = $this->calculateCost($quoteItem->getProduct(), $engravedName);
        $quoteItem->setCustomPrice($cost);
        $quoteItem->setOriginalCustomPrice($cost);

        //$quoteItem->getProduct()->setIsSuperMode(true);
        //$quoteItem->save();
    }

    public function calculateCost($product, $engravedName)
    {
        $engravedCharacterCost = Mage::helper('camelcase_engravable/data')->getConfigCharacterCost();
        $engravedCharacterCount = strlen($engravedName);
        $engravingCost = $engravedCharacterCost * $engravedCharacterCount;

        return $product->getPrice() + $engravingCost;
    }

}