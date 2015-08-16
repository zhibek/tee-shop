<?php
/**
 * Add "engraved_name" & "engraved_date" attribute on "quote_item" & "order_item"
 */

/* @var $installer Mage_Sales_Model_Resource_Setup */
$installer = new Mage_Sales_Model_Resource_Setup('core_setup');

$entities = array(
    'quote_item',
    'order_item',
);

$attributes = array(
    'engraved_name' => array(
        'type'     => Varien_Db_Ddl_Table::TYPE_VARCHAR,
        'visible'  => true,
        'required' => false,
    ),
    'engraved_date' => array(
        'type'     => Varien_Db_Ddl_Table::TYPE_VARCHAR,
        'visible'  => true,
        'required' => false,
    ),
);

foreach ($entities as $entity) {
    foreach ($attributes as $attribute => $options) {
        $installer->addAttribute($entity, $attribute, $options);
    }
}

$installer->endSetup();