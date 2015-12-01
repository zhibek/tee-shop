<?php

/* In this upgarde we'll create 10 simple products that 'll be assigned 
  to the configurable product */

//
//$primaryColours = array(
//    '0' => 'White',
//    '1' => 'Black',
//    '2' => 'Green',
//    '3' => 'Red',
//    '4' => 'Brown',
//    '5' => 'Blue'
//);
//$colours = array(
//    '0' => 'Pure',
//    '1' => 'Off',
//    '2' => 'Light',
//    '3' => 'Pale',
//    '4' => 'Hot',
//    '5' => 'Dark'
//);
//$sizes = array(
//    '0' => 'XS',
//    '1' => 'S',
//    '2' => 'M',
//    '3' => 'L',
//    '4' => 'XL'
//);
//
//Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
//
//$helper = Mage::helper('teeshop_catalog');
//
//$product = Mage::getModel('catalog/product');
//foreach ($primaryColours as $primaryColour){
//    foreach ($colours as $colour) {
//        foreach ($sizes as $size) {
//
//            $product = Mage::getModel('catalog/product');
//
//            $product
//                    ->setWebsiteIds(array(1))
//                    ->setAttributeSetId($product->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
//                    ->setTypeId('simple') //product type
//                    ->setCreatedAt(strtotime('now')) //product creation time
//                    ->setSku('T-shirt '.$colour. ' ' . $primaryColour . ' ' . $size) //SKU
//                    ->setName('T-shirt '.$colour. ' ' . $primaryColour . ' ' . $size) //product name
//                    ->setWeight(4.00)
//                    ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
//                    ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
//                    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
//                    ->setPrice(11.22) //price in form 11.22
//                    ->setMetaTitle('T-shirt '.$colour. ' ' . $primaryColour . ' ' . $size)
//                    ->setMetaKeyword('T-shirt '.$colour. ' ' . $primaryColour . ' ' . $size)
//                    ->setMetaDescription("This's Long Description !!")
//                    ->setDescription("This's Long Description !!")
//                    ->setShortDescription("This's Short Description !!")
//                    ->setStockData(array(
//                        'is_in_stock' => 1, //Stock Availability
//                        'qty' => 100 //qty
//                            )
//            );
//            $product->setPrimaryColour($helper->getPrimaryColourOptionValue($primaryColour));
//            $product->setSize($helper->getSizeOptionValue($size));
//            $product->setColor($helper->getColourOptionValue($colour));
//            $brand='Nike';
//            $product->setBrand($helper->getBrandOptionValue($brand));
//            $product->setFabricCare('Machine Wash,COLD');
//            $product->save();
//        }
//    }
//
//}