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

    public function setQuoteItem($quoteItem)
    {
        $this->quoteItem = $quoteItem;
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

    public function addAttributesToQuoteItem(Varien_Event_Observer $observer)
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
            $engravableDate = date("Y-m-d", strtotime($this->getQuoteItem()->getCreatedAt()));
            $this->engravableDate = $engravableDate;
        }
        return $this->engravableDate;
    }

    public function saveQuoteItem(Varien_Event_Observer $observer)
    {
        $this->setQuoteItem($observer->getEvent()->getQuoteItem());
    }

    public function countCharacters()
    {
        $engravableName = $this->getEngravableName();
        $engravableDate = $this->getEngravableDate();

        $count = strlen(trim(str_replace(" ", "", $engravableName))) + strlen(trim($engravableDate));

        return $count;
    }

    public function makeQuoteItemForEachEngravableProduct(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuoteItem()->getQuote();
        $items = $quote->getAllItems();
        foreach ($items as $item) {
            Mage::log(__METHOD__ . " :: prodcut is_engravable :: " . $item->getProduct()->getData()["is_engravable"]);
            Mage::log(__METHOD__ . " :: item qty:: " . $item->getQty());
            $isEngravable = (bool) $item->getProduct()->getData()["is_engravable"];
            $itemQty = $item->getQty();

            if ($isEngravable && $itemQty > 1) {
                $this->separateQuoteItems($quote, $item);
            }
        }
    }

    protected function separateQuoteItems(Mage_Sales_Model_Quote $quote, Mage_Sales_Model_Quote_Item $item)
    {
        $newItem = clone $item;
        $newItem->setQty(1);

        $quote->addItem($newItem);

        $item->setQty($item->getQty() - 1);
        
        if($item->getQty()>1){
            $this->separateQuoteItems($quote, $item);
        }
        
        $quote->save();
    }

}
