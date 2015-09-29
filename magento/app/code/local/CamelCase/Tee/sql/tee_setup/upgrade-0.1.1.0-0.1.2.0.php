<?php

// here we create the Test Product category 
$store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
$parentId = $store->getRootCategoryId();
 
$category = Mage::getModel('catalog/category');
$category->setName('Test Products')
    ->setIsActive(1)                       
    ->setDisplayMode('PRODUCTS')
    ->setIsAnchor(1)
    ->setCustomDesignApply(1)
    ->setAttributeSetId($category->getDefaultAttributeSetId());

$parentCategory = Mage::getModel('catalog/category')->load($parentId);
$category->setPath($parentCategory->getPath());

$category->save();
//unset($category);
