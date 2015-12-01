<?php

// here we create the new 3 top categories and their subs

$helper = Mage::helper('teeshop_catalog');
$topCategories = array('Men', 'Women', 'Children');
$subCategories = array('Sport', 'Music', 'Art');

foreach ($topCategories as $top) {
    $helper->createTopCategory($top);
    foreach ($subCategories as $sub) {
        $helper->createSubCategory($sub, $top);
    }
}