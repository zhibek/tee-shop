
<?php

$this->startSetup();
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
