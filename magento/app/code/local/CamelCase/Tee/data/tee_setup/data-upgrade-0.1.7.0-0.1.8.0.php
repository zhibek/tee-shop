<?php

// assinging our 10 shirts to Base CONFIG SHirt

$colourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', 'primary_colour');

$sizeId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', 'size');

$category_id = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

$Config = Mage::getModel('catalog/product')->loadByAttribute('name', 'Base Config Product')->getId();
// loading base config product
$configurable = Mage::getModel('catalog/product')->load($Config);
//getting shirts ids
$simpleIds = array(
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_Black_XL')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_Black_L')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_Black_M')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_Black_S')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_Black_XS')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_White_XL')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_White_L')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_White_M')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_White_S')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt_White_XS')->getId()
);
// loading collection of our shirts
$simpleProducts = Mage::getResourceModel('catalog/product_collection')
        ->addIdFilter($simpleIds)
        ->addAttributeToSelect('primary_colour')
        ->addAttributeToSelect('size');

$configurableProductsData = array();
$configurableAttributesData = $configurable->getTypeInstance()->getConfigurableAttributesAsArray();

foreach ($simpleProducts as $simple) {

    $configurableProductsData[$simple->getId()] = $simple;
    $configurableAttributesData[0]['values'][] = $simple;
}

$configurable->setConfigurableProductsData($configurableProductsData);
$configurable->setConfigurableAttributesData($configurableAttributesData);
$configurable->setCanSaveConfigurableAttributes(true);
Mage::log($configurableProductsData, null, 'configurableProductsData.log', true);
Mage::log($configurableAttributesData, null, 'configurableAttributesData.log', true);
$configurable->save();

// rindexing Stock Status table to make sure tha base config product in stock
$reindex = Mage::getModel('index/process')->load(8);
$reindex ->reindexAll();
