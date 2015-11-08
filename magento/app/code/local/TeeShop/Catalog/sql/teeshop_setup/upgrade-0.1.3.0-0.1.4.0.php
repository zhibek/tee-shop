<?php

/*
 * Here we edit attributes
 */

//editing price attribute to appear on search filters
$price = Mage::getSingleton("eav/config")->getAttribute('catalog_product', 'price');
$price->setIsFilterableInSearch(1)->save();
