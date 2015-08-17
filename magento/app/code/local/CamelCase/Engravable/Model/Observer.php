<?php

class CamelCase_Engravable_Model_Observer
{

    protected $observer;
    protected $engravableName;
    protected $engravableDate;
    protected $quoteItem;
    protected $product;

    public function setObserver($observer)
    {
        $this->observer = $observer;
    }

    public function getObserver()
    {
        return $this->observer;
    }
    
    public function getQuoteItem()
    {
        return $this->quoteItem;
    }
    
    public function setProduct($product)
    {
        $this->product = $product;
    }
    
    public function getProduct()
    {
        return $this->product;
    }

    protected function logEvent()
    {
        if ($this->isEngravable()) {

            $engravableName = $this->getEngravableName();
            $engravableDate = $this->getEngravableDate();

            Mage::log($this->getObserver()->getEvent()->getName() . ' :: Adding new engravable ring to the cart with name (' . $engravableName . ') and date (' . $engravableDate . ')');
        }
    }

    public function addAttributesToQuoteItem($observer)
    {
        $this->setObserver($observer);

        $this->logEvent();

//        if ($this->isEngravable()) {
//            $engravableName = $this->getEngravableName();
//            $engravableDate = $this->getEngravableDate();
//
//            $quoteItem = $observer->getEvent()->getQuoteItem();
//
//            $quoteItem->setDate('engravable_name', $engravableName);
//            $quoteItem->setDate('engravable_date', $engravableDate);
//
//            $quoteItem->save();
//        }
    }

    protected function isEngravable()
    {
        $observer = $this->getObserver();
        $product = $observer->getEvent()->getProduct();
        $this->setProduct($product);
        $productData = $product->getData();
//        var_dump($productData);exit;
        return (boolean) $productData['is_engravable'];
    }

    protected function getEngravableName()
    {
        if (is_null($this->engravableName)) {
            $postData = Mage::app()->getRequest()->getPost();
            $engravableName = $postData['engravable_name'];
            $this->engravableName = $engravableName;
        }
        return $this->engravableName;
    }

    protected function getEngravableDate()
    {
        if (is_null($this->engravableDate)) {
            $observer = $this->getObserver();   
            $engravableDate = date("Y-m-d", strtotime($this->getQuoteItem()->getCreatedAt()));
            $this->engravableDate = $engravableDate;
        }
        return $this->engravableDate;
    }
    
    public function saveQuoteItem($observer)
    {
        $this->quoteItem = $observer->getEvent()->getQuoteItem();
    }

}
