<?php

// here we create our test product to work with 
Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
$product = Mage::getModel('catalog/product');
$category_id = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

$product
        ->setWebsiteIds(array(1))
        ->setAttributeSetId($product->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
        ->setTypeId('simple') //product type
        ->setCreatedAt(strtotime('now')) //product creation time
        ->setSku('testsku17') //SKU
        ->setName('Test T-Shirt') //product name
        ->setWeight(8.00)
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setPrice(11.22) //price in form 11.22
        ->setCost(22.33) //price in form 11.22
        ->setMetaTitle('test meta title')
        ->setMetaKeyword('testproduct')
        ->setMetaDescription('test meta description')
        ->setDescription('This is a long description')
        ->setShortDescription('This is a short description')
        ->setStockData(array(
            'is_in_stock' => 1, //Stock Availability
            'qty' => 999 //qty
                )
        )
        ->setCategoryIds(array($category_id)); //assign product to categories
$product->save();
