<?php

//// adding conf product to the new categories

////loading the conf product
//$configProduct = Mage::getModel('catalog/product')->loadByAttribute('name', 'Base Config Product');
//
//$categories = array();
///*
// *We Removed Test Products Category after testing it
//$topCats = array('Men', 'Women', 'Children','Test Products'); 
// */
//$topCats = array('Men', 'Women', 'Children');
//
//
//foreach ($topCats as $top) {
//    // loading top category
//    $topCategory = Mage::getResourceModel('catalog/category_collection')
//            ->addFieldToFilter('name', $top)
//            ->getFirstItem();
//    // getting top category's id
//    $topCategoryId = $topCategory->getId();
//    // adding id to id list
//    // we need to make sure that product shows up in both top and sub catgeory
//    array_push($categories, $topCategoryId);
//    // getting children of top category 
//    $subCategories = $topCategory->getChildrenCategories();
//
//    foreach ($subCategories as $sub) {
//        //adding sub cat's id to array list
//        array_push($categories, $sub->getId());
//    }
//}
//
//$configProduct->setCategoryIds($categories);
//$configProduct->save();
