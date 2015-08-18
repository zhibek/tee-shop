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

        if ($this->isEngravable()) {
            // save name and date to quote item 

            $engravableName = $this->getEngravableName();
            $engravableDate = $this->getEngravableDate();

            $quoteItem = $this->getQuoteItem();

            $quoteItem->setData('engravable_name', $engravableName);
            $quoteItem->setData('engravable_date', $engravableDate);

            // update quote item price based on engraved characters
            $pricePerCharacter = (float) Mage::getStoreConfig(CamelCase_Engravable_Helper_Data::CONFIG_CHARACTER_PRICE);
            $charactersCount = $this->countCharacters();
            
            $newPrice = $quoteItem->getPriceInclTax() + $pricePerCharacter * $charactersCount;
            $quoteItem->setOriginalCustomPrice($newPrice);
            
            $quoteItem->save();
        }
    }

    protected function isEngravable()
    {
        $observer = $this->getObserver();
        $product = $observer->getEvent()->getProduct();
        $this->setProduct($product);
        $productData = $product->getData();

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

    public function countCharacters()
    {
        $engravableName = $this->getEngravableName();
        $engravableDate = $this->getEngravableDate();
        
        $count = strlen( trim(str_replace(" ", "", $engravableName)) ) + strlen(trim($engravableDate));
        
        return $count;
    }

}
