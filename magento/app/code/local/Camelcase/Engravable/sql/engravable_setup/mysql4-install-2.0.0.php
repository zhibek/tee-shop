
<?php

$this->startSetup();
var_dump(111);exit;
$this->addAttribute(
        'catalog_product', 'is_engravable', array(
    'input' => 'boolean',
    'type' => 'int',
    'label' => 'Is Engravable',
    'required' => true,
    'sort_order' => 100
        )
);

$this->endSetup();
