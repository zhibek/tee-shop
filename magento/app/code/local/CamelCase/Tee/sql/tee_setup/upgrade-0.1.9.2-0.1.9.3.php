<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* In this upgarde we'll create 10 simple products that 'll be assigned 
  to the configurable product */

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

$Colours = array(
    '0' => 'White',
    '1' => 'Black'
);
$Sizes = array(
    '0' => 'XS',
    '1' => 'S',
    '2' => 'M',
    '3' => 'L',
    '4' => 'XL'
);

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$product = Mage::getModel('catalog/product');

$category_id = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

foreach ($Colours as $colour) {
    foreach ($Sizes as $size) {

        try {
            Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

            $product = Mage::getModel('catalog/product');

            $product->setWebsiteIds(1)
                    ->setAttributeSetId($product->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
                    ->setTypeId('simple') //product type
                    ->setCreatedAt(strtotime('now')) //product creation time
                    ->setSku('T-shirt_' . $colour . '_' . $size) //SKU
                    ->setName('T-shirt_' . $colour . '_' . $size) //product name
                    ->setWeight(4.00)
                    ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                    ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
                    ->setPrice(11.22) //price in form 11.22
                    ->setCost(22.33) //price in form 11.22
                    ->setMetaTitle('T-shirt_' . $colour . '_' . $size)
                    ->setMetaKeyword('T-shirt_' . $colour . '_' . $size)
                    ->setMetaDescription("This's Long Description !!")
                    ->setDescription("This's Long Description !!")
                    ->setShortDescription("This's Short Description !!")
                    ->setStockData(array(
                        'is_in_stock' => 1, //Stock Availability
                        'qty' => 100 //qty
                            )
                    )
                    ->setCategoryIds(array($category_id)); //assign product to categories
            $product->setPrimaryColour(getAttributeOptionValue('primary_colour', $colour));
            $product->setSize(getAttributeOptionValue('size', $size));
            $product->setBrand('NIKE');
            $product->setFabricCare('Machine Wash,COLD');
            $product->save();
        } catch (Exception $e) {
            Mage::log($e->getMessage());
        }
    }
}


