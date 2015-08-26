<?php

class Camelcase_Engravable_Model_Observer {

    protected $observer;

    private function setObserver($observer) {
        $this->observer = $observer;
    }

    private function getObserver() {
        return $this->observer;
    }

    private function getDateNow() {

        return Mage::getModel('core/date')->date('Y-m-d');
    }

    private function getEngravedName() {
        if ($this->checkEngravability()) {
            $requestData = Mage::app()->getRequest()->getPost();
            $engravedName = $requestData['userEngravedName'];
        }
        return $engravedName;
    }

    // need to add fun to set the product global and protected var 
    private function checkEngravability() {
        $observer = $this->getObserver();
        $product = $observer->getEvent()->getProduct();
        $productData = $product->getData();
        return $productData['is_engravable'];
    }

    private function engravingPrice() {

        $strLength = strlen($this->getEngravedName()) + 1 + strlen($this->getDateNow());
        $addationalPrice = $strLength * 0.5;
        return $addationalPrice;
    }

    public function shopSystemLog($observer) {
        $this->setObserver($observer);
        if ($this->checkEngravability()) {
            $engravedName = $this->getEngravedName();
            $engravedDate = $this->getDateNow();
            Mage::log('A new engraved ring had been Added to the cart with name "'
                    . $engravedName . '" at "' . $engravedDate . '"');
            // adding to quote entity table after adding to cart
            $quoteItem = $observer->getEvent()->getQuoteItem();
            $quoteItem->setData('engraved_name', $engravedName);
            $quoteItem->setData('engraved_date', $engravedDate);
            // getting the original price 
            $product = $observer->getEvent()->getProduct();
            $OrgPrice = $product->getPrice();
            // updating price of the qoute item insted of the original price 
            $newPrice = $OrgPrice + $this->engravingPrice();
            $quoteItem->setOriginalCustomPrice($newPrice);
            $quoteItem->save();
        }
    }

}
