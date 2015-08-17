<?php

class CamelCase_Engravable_Model_Observer
{

    public function logEvent($observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productData = $product->getData();

        if ((boolean) $productData['is_engravable']) {

            $postData = Mage::app()->getRequest()->getPost();
            $engravableName = $postData['engravable_name'];

            $creationDate = date("Y-m-d", strtotime($observer->getEvent()->getQuoteItem()->getCreatedAt()));
            
            Mage::log('Adding new engravable ring to the cart with name (' . $engravableName . ') and date ('.$creationDate.')');
        }
    }

}
