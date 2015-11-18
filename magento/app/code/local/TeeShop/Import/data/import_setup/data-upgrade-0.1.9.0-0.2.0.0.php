<?php

//Import our json products file
$helper = Mage::helper('import');
Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
$content = TeeShop_Import_Model_Products::getInstance();
foreach ($content->instance['products'] as $productData) {
    foreach ($productData['variants'] as $simple) {
        $product = Mage::getModel('catalog/product');
        $product
                ->setWebsiteIds(array(1))
                ->setAttributeSetId($product->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
                ->setTypeId('simple') //product type
                ->setCreatedAt(strtotime('now')) //product creation time
                ->setSku($simple['sku']) //SKU
                ->setName($productData['title']) //product name
                ->setWeight(4)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
                ->setPrice($productData['price']) //price in form 11.22
                ->setMetaTitle($productData['title'])
                ->setMetaKeyword($productData['title'])
                ->setMetaDescription($productData['title'])
                ->setDescription($productData['description'])
                ->setShortDescription($productData['title'])
                ->setStockData(array(
                    'is_in_stock' => 1, //Stock Availability
                    'qty' => 100 //qty
                        )
                )
                ->setCategoryIds($helper->prepareCategories($productData['categories'][0]));
        $product->setColor($helper->getColourOptionValue($simple['colour']));
        $product->setPrimaryColour($helper->getPrimaryColourOptionValue($simple['primary_colour']));
        $product->setSize($helper->getSizeOptionValue($simple['size']));
        $product->setBrand($helper->getBrandOptionValue($productData['brand']));
        $product->setFabricCare($productData["fabric_care"]);
        $product->save();
    }
}
    