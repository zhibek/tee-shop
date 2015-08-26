<?php


class CamelCase_Engravable_Model_Observer
{
    public function logNameAndDate($observer)
    {
        $params = Mage::app()->getRequest()->getPost();
        $name = $params['options'][3] ? $params['options'][3] : false;
        if(!empty($name)) {
            $date  = date('d-m-Y');
                /* @var $quote Mage_Sales_Model_Quote */
            $quote = $observer->getEvent()->getQuote();
            $collection = $quote->getItemsCollection();
            $quote_item = $collection->getLastItem();
            $character_price = Mage::getStoreConfig('engravable/default/character_price');
            $newPrice  = $quote_item->getBasePrice() + strlen($name) * $character_price;
            $quote_item->setData('engraved_name', $name);
            $quote_item->setData('engraved_date', $date);
            $quote_item->setOriginalCustomPrice($newPrice);
            $quote_item->save();
            Mage::log("This an engravable Ring With Name '{$params['engravable_name']}' and date {$date}");
        }
    }
}
