<?php

class Camelcase_Engravable_Model_Observer {

    protected $observer;
    protected $engravedName;
    protected $engravedDate;
    protected $quoteItem;

    private function setObserver($observer) {
        $this->observer = $observer;
    }

    public function setQuoteItem($quoteItem) {
        $this->quoteItem = $quoteItem;
    }

    private function getObserver() {
        return $this->observer;
    }

    private function getDateNow() {
        $this->engravedDate = Mage::getModel('core/date')->date('Y-m-d');
        return $this->engravedDate;
    }

    private function getEngravedName() {
        if ($this->checkEngravability()) {
            $requestData = Mage::app()->getRequest()->getPost();
            $this->engravedName = $requestData['userEngravedName'];
        }
        return $this->engravedName;
    }

    // need to add fun to set the product global and protected var 
    private function checkEngravability() {
        $observer = $this->getObserver();
        $product = $observer->getEvent()->getProduct();
        $productData = $product->getData();
        return $productData['is_engravable'];
    }

    private function prepareData($string) {
        // no need for any spaces 
        return trim(str_replace(" ", "", $string));
    }

    private function engravingPrice() {

        $strLength = strlen($this->prepareData($this->engravedName)) +
                strlen($this->prepareData($this->engravedDate));
        $addationalPrice = $strLength * Mage::getStoreConfig('engravable/default/char_price');
        return $addationalPrice;
    }

    private function newPrice() {
        // getting the original price 
        $product = $this->getObserver()->getEvent()->getProduct();
        $OrgPrice = $product->getPrice();
        return $OrgPrice + $this->engravingPrice();
    }

    public function addMultipleEngravedRings($observer) {
        $this->setObserver($observer);

        if ($this->checkEngravability()) {

            $this->engravedName = $this->getEngravedName();
            $this->engravedDate = $this->getDateNow();

            Mage::log('A new engraved ring had been Added to the cart with name "'
                    . $this->engravedName . '" at "' . $this->engravedDate . '"');

            // adding to quote entity table after adding to cart
            $quoteItem = $observer->getEvent()->getQuoteItem();

            $quoteItem->setData('engraved_name', $this->engravedName);
            $quoteItem->setData('engraved_date', $this->engravedDate);
            // updating price of the qoute item insted of the original price 
            $quoteItem->setOriginalCustomPrice($this->newPrice());
            $quoteItem->save();
        }

        $this->checkItemExistence($observer);
    }

    private function checkItemExistence($observer) {

        $quote = $observer->getEvent()->getQuoteItem()->getQuote();
        $items = $quote->getAllItems();
        foreach ($items as $item) {
            $itemQty = $item->getQty();
            if ($this->checkEngravability() && ($itemQty > 1)) {
                $this->separateItems($quote, $item, $observer);
            }
        }
    }

    private function separateItems($quote, $item, $observer) {

        $newlyAddedItem = clone $item;
        $newlyAddedItem->setQty(1);
        $newlyAddedItem->setOriginalCustomPrice($this->newPrice());
        $quote->addItem($newlyAddedItem);
        $item->setQty($item->getQty() - 1);
        $quote->save();
        $this->setQuoteItem($newlyAddedItem);
        $this->checkItemExistence($observer);
    }
    
}
