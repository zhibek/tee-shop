<!--Discard-->
<!--Discard-->
<!--Discard-->
<!--Discard-->
<!--Discard-->

<?php
$installer = $this;

$installer->startSetup();
// targetting sales_flat_quote_item  & sales_flat_order_item
$entities = array('quote_item', 'order_item');
// Our new fields 
$newAttributes = array('engraved_name','engraved_date');

$newOptions = array(
//    field type is varchar(255)
    'type' => Varien_Db_Ddl_Table::TYPE_VARCHAR,
    'visible' => true,
//    Not alwayes required only for engraved items 
    'required' => false
);

foreach($entities as $entity ){    
    foreach($newAttributes as $att){    
        $installer->addAttribute($entity,$att,$newOptions);
    }
}

$installer->endSetup();

