<?php


class CamelCase_Engravable_Model_Observer
{
    public function logNameAndDate($observer)
    {
        $params = Mage::app()->getRequest()->getPost();
        if(!empty($params['engravable_name'])) {
            $date  = date('d-m-Y');
                /* @var $quote Mage_Sales_Model_Quote */
            $quote = $observer->getEvent()->getQuote();
            $product = Mage::getSingleton('catalog/product')->load($params['product']);
            $quote_item  = $quote->getItemByProduct($product);
            $character_price = Mage::getStoreConfig('engravable/default/character_price');
            $newPrice  = $quote_item->getBasePrice() + strlen($params['engravable_name']) * $character_price;
            $quote_item->setData('engraved_name', $params['engravable_name']);
            $quote_item->setData('engraved_date', $date);
            $quote_item->setOriginalCustomPrice($newPrice);
            $quote_item->save();
            Mage::log("This an engravable Ring With Name '{$params['engravable_name']}' and date {$date}");
            
            $this->checkForRepeatedItems($observer);
        }
    }

    private function checkForRepeatedItems($observer)
    {
        $quote = $observer->getEvent()->getQuote();
        $items = $quote->getAllItems();
        foreach ($items as $item) {
            $itemQty = $item->getQty();            
            if ($itemQty > 1) {             
                $this->separateItems($quote, $item, $observer);
                
            }
        }
    }
    
      private function separateItems($quote, $item, $observer) {
        $newlyAddedItem = clone $item;
        $newlyAddedItem->setQty(1);
        $character_price = Mage::getStoreConfig('engravable/default/character_price');
        $newPrice  = $newlyAddedItem->getBasePrice() + strlen($newlyAddedItem->getEngravedName()) * $character_price;
        $newlyAddedItem->setOriginalCustomPrice($newPrice);
        $quote->addItem($newlyAddedItem);
        $item->setQty($item->getQty() - 1);
        $quote->save();
        $this->checkForRepeatedItems($observer);
     }

}
