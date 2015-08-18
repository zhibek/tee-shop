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
            $quote_item->setData('engraved_name', $params['engravable_name']);
            $quote_item->setData('engraved_date', $date);
            $quote_item->save();
            Mage::log("This an engravable Ring With Name '{$params['engravable_name']}' and date {$date}");
        }
    }
}
