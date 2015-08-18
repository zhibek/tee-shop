<?php
$installer = new Mage_Sales_Model_Resource_Setup("core_setup");
$installer->startSetup();
$installer->addAttribute("order_item", "engraved_name", array("type"=>"varchar"));
$installer->addAttribute("quote_item", "engraved_name", array("type"=>"varchar"));
$installer->addAttribute("order_item", "engraved_date", array("type"=>"varchar"));
$installer->addAttribute("quote_item", "engraved_date", array("type"=>"varchar"));
$installer->endSetup();
