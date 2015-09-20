<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Resource
$resource = Mage::getSingleton('core/resource'); 
//database write adapter 
$write = Mage::getSingleton('core/resource')->getConnection('core_write');

$write->update(
        "eav_attribute",
        array("attribute_code" => 'primary_colour'),
        "attribute_code='primary-colour'"

);
 
$write->update(
        "eav_attribute",
        array("attribute_code" => 'fabric_care'),
        "attribute_code='fabric-care'"

);


