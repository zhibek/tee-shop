<?php

class Teeshop_Engrave_Model_Observer {

    /**
     * Log engraved name and time on adding product to cart
     * @access public
     * 
     * @return null stop if no product is found
     */
    public function addCart() {

        $product = Mage::getModel('catalog/product')
                ->load(Mage::app()->getRequest()->getParam('product', 0));


        if (!$product->getId()) {
            return;
        }
        $isEngravable = (bool) $product->getIsEngravable();
        if ($isEngravable === true) {
            $requestParameters = Mage::app()->getRequest()->getParams();
            if (array_key_exists('engraved_name', $requestParameters)) {
                $engravedName = $requestParameters['engraved_name'];
                Mage::log("new_product_with_engrave: $engravedName ,on: " . date(/* $format = */ DATE_ATOM), /* $level = */ Zend_Log::INFO);
            }
        }
    }

    /**
     * Save engraved name and time on adding product to cart
     * Update price for product with engravable
     * Separate engravable products by distinguishing them
     * @access public
     * 
     * @param object $observer
     * @return null stop if no product is found
     */
    public function addItem($observer) {

        $quoteItem = $observer->getQuoteItem();
        $product = $quoteItem->getProduct();

        if (!$product->getId()) {
            return;
        }
        $isEngravable = (bool) $product->getIsEngravable();
        if ($isEngravable === true) {
            
            // separate engravable products
            $data['microtime'] = microtime(true);
            $product->addCustomOption('do_not_merge', serialize($data));
            $quoteItem->addOption($product->getCustomOption('do_not_merge'));
            
            $requestParameters = Mage::app()->getRequest()->getParams();
            $originalPrice = $product->getFinalPrice();
            // sectionName/groupName/fieldName
            $pricePerCharacter = Mage::getStoreConfig('engrave/general/price_per_character');
            // remove old engrave price
            if (!empty($quoteItem->getEngravedName())) {
                $originalPrice -= (strlen($quoteItem->getEngravedName()) * $pricePerCharacter);
            }
            // set engrave name -and engrave date, if new engrave name is posted- 
            if (array_key_exists('engraved_name', $requestParameters) && !empty($requestParameters['engraved_name'])) {
                $engravedName = $requestParameters['engraved_name'];
                $quoteItem->setEngravedName($engravedName);
                $quoteItem->setEngravedDate(date(/* $format = */ DATE_ATOM));
            } elseif (!empty($quoteItem->getEngravedName())) {
                $engravedName = $quoteItem->getEngravedName();
            }
            // add new engrave price
            $newPrice = $originalPrice + strlen($engravedName) * $pricePerCharacter;
            $quoteItem->setCustomPrice($newPrice)->setOriginalCustomPrice($newPrice);
        }
    }

}
