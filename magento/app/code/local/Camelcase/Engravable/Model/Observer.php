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
        if (is_null($this->checkEngravability())) {
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

    public function shopSystemLog($observer) {
        $this->setObserver($observer);
        if ($this->checkEngravability()) {
            $engravedName = $this->getEngravedName();
            $engravedDate = $this->getDateNow();
            Mage::log('A new engraved ring had been Added to the cart with name "' . $engravedName . '" at "' . $engravedDate . '"');
        }
    }

}
