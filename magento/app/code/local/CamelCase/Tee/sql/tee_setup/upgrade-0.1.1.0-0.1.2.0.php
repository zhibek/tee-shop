<?php

// here we create the Test Product category 

$store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
$parentId = $store->getRootCategoryId();
$parentCategory = Mage::getModel('catalog/category')->load($parentId);
 
$category = Mage::getModel('catalog/category');
$category
    ->setName('Test Products')
    ->setIsActive(1)                       
    ->setDisplayMode('PRODUCTS')
    ->setIsAnchor(1)
    ->setCustomDesignApply(1)
    ->setAttributeSetId($category->getDefaultAttributeSetId())
    ->setStoreId($store->getId())
    ->setPath($parentCategory->getPath());

$category->save();

/*
$process = Mage::getSingleton('index/indexer')->getProcessByCode('catalog_category_flat');
$process->reindexEverything();
*/