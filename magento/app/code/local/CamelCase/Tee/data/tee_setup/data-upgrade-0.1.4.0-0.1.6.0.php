<?php

/* In this upgarde we'll create 10 simple products that 'll be assigned 
  to the configurable product */


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

Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);

$helper = Mage::helper('tee');

$product = Mage::getModel('catalog/product');

$category_id = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

foreach ($Colours as $colour) {
    foreach ($Sizes as $size) {

        $product = Mage::getModel('catalog/product');

        $product
                ->setWebsiteIds(array(1))
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
                ->setMetaTitle('T-shirt_' . $colour . '_' . $size)
                ->setMetaKeyword('T-shirt_' . $colour . '_' . $size)
                ->setMetaDescription("This's Long Description !!")
                ->setDescription("This's Long Description !!")
                ->setShortDescription("This's Short Description !!")
                ->setStockData(array(
                    'is_in_stock' => 1, //Stock Availability
                    'qty' => 100 //qty
                        )
        );
        $product->setPrimaryColour($helper->getAttributeOptionValue('primary_colour', $colour));
        $product->setSize($helper->getAttributeOptionValue('size', $size));
        $product->setBrand('NIKE');
        $product->setFabricCare('Machine Wash,COLD');
        $product->save();
    }
}