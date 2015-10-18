<?php
// adding our product attributes (fabric_care , primary_colour , size , brand )

$installer = $this;
$installer->startSetup();
$installer->addAttribute('catalog_product', 'brand', array(
    'group'             => 'General',
    'type'              => 'varchar',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Brand',
    'input'             => 'text',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => true,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true
));

$installer->addAttribute('catalog_product', 'fabric_care', array(
    'group'             => 'General',
    'type'              => 'varchar',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Fabric care',
    'input'             => 'text',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => true,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true
));

$installer->addAttribute('catalog_product', 'primary_colour', array(
    'attribute_model' => NULL,
    'group'             => 'General',
    'type'              => 'int',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'label'             => 'Primary colour',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => true,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => true,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true,
    'option'            => array(
            'values' => array(
                    '0'  => 'White',
                    '1'  => 'Black',
                    '2'    => 'Red',
                    '3'   => 'Blue',
                    '4'  => 'Green',
                    '5' => 'Yellow',
                    '6' => 'Purple',
                    '7'  => 'Brown',
            )
    )
));

$installer->addAttribute('catalog_product', 'size', array(
    'attribute_model' => NULL,
    'group'             => 'General',
    'type'              => 'int',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'label'             => 'Size',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => true,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true,
    'option'            => array(
            'values' => array(
                    '0'     => 'XS',
                    '1'      => 'S',
                    '2'      => 'M',
                    '3'      => 'L',
                    '4'     => 'XL',
            )
        )
));

$installer->endSetup();
