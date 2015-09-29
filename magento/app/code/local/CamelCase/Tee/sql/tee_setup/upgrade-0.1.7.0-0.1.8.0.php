<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// assinging our 10 shirts to Base CONFIG SHirt

function getAttributeOptionValue($arg_attribute, $arg_value) {
    $attribute_model = Mage::getModel('eav/entity_attribute');
    $attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

    $attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
    $attribute = $attribute_model->load($attribute_code);

    $attribute_table = $attribute_options_model->setAttribute($attribute);
    $options = $attribute_options_model->getAllOptions(false);

    foreach ($options as $option) {
        if ($option['label'] == $arg_value) {
            return $option['value'];
        }
    }

    return false;
}

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
