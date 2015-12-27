<?php

class Teeshop_Engrave_Model_Observer {

    public function addCart() {

        $product = Mage::getModel('catalog/product')
                ->load(Mage::app()->getRequest()->getParam('product', 0));


        if (!$product->getId()) {
            return;
        }
        $isEngravable = (bool) $product->getIsEngravable();
        if ($isEngravable === true) {
            $requestParameters = Mage::app()->getRequest()->getParams();
            if (array_key_exists('engraved_name', $requestParameters)) {
                $engravedName = $requestParameters['engraved_name'];
                Mage::log("new_product_with_engrave: $engravedName ,on: " . date(/* $format = */ DATE_ATOM), /* $level = */ Zend_Log::INFO);
            }
        }
    }

    public function setQuote($observer) {

        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();

        if (!$product->getId()) {
            return;
        }
        $isEngravable = (bool) $product->getIsEngravable();
        if ($isEngravable === true) {
            $requestParameters = Mage::app()->getRequest()->getParams();
            $originalPrice = $quoteItem->getPrice();
            // sectionName/groupName/fieldName
            $pricePerCharacter = Mage::getStoreConfig('engrave/general/price_per_character');
            // remove old engrave price
            if (!empty($quoteItem->getEngravedName())) {
                $originalPrice -= (strlen($quoteItem->getEngravedName()) * $pricePerCharacter);
            }
            // set engrave name -and engrave date, if new engrave name is posted- 
            if (array_key_exists('engraved_name', $requestParameters) && !empty($requestParameters['engraved_name'])) {
                $engravedName = $requestParameters['engraved_name'];
                $quoteItem->setEngravedName($engravedName);
                $quoteItem->setEngravedDate(date(/* $format = */ DATE_ATOM));
            } elseif (!empty($quoteItem->getEngravedName())) {
                $engravedName = $quoteItem->getEngravedName();
            }
            // add new engrave price
            $newPrice = $originalPrice + strlen($engravedName) * $pricePerCharacter;
            $quoteItem->setCustomPrice($newPrice)->setOriginalCustomPrice($newPrice);
        }
    }

}
