<?php

/*
  NOTE : Reindexing Values
  $reindex = Mage::getModel('index/process')->load($value);
  $reindex ->reindexAll();
  1 : Attributes
  2 : Product Prices
  3 : Catalog URL Rewrites
  4 : Product falt data
  5 : Category Flat Data
  6 : Category Products
  7 : Catalog Search Index
  8 : Stock Status
  9 : Tag Aggregation Data
 */

//Here we're assinging our 10 shirts to Base CONFIG SHirt

$colourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_PRIMARY_COLOUR);

$sizeId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_SIZE);

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
        ->addAttributeToSelect(TeeShop_Catalog_Helper_Data::ATTRIBUTE_PRIMARY_COLOUR)
        ->addAttributeToSelect(TeeShop_Catalog_Helper_Data::ATTRIBUTE_SIZE);

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
$reindex->reindexAll();
