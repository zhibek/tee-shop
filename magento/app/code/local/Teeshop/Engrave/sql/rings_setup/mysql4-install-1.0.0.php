<?php
$parentId = 2; // default category
$category = Mage::getModel('catalog/category');
$category->setName('Rings');
$category->setUrlKey('new-category');
$category->setIsActive(1);
$category->setDisplayMode('PRODUCTS');
$category->setIsAnchor(1); //for active anchor
$category->setStoreId(Mage::app()->getStore()->getId());
$parentCategory = Mage::getModel('catalog/category')->load($parentId);
$category->setPath($parentCategory->getPath());
$category->save();
