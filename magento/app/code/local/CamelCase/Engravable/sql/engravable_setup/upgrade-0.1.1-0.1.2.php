<?php

$installer = new Mage_Sales_Model_Resource_Setup('core_setup');

$installer->startSetup();

$entities = array(
    'quote_item',
    'order_item'
);

$attributes = array(
    'engravable_name',
    'engravable_date'
);

$options = array(
    'type' => Varien_Db_Ddl_Table::TYPE_VARCHAR,
    'visible' => true,
    'required' => false
);

foreach ($entities as $entity) {
    foreach ($attributes as $attribute) {
        $installer->addAttribute($entity, $attribute, $options);
    }
}

$installer->endSetup();
