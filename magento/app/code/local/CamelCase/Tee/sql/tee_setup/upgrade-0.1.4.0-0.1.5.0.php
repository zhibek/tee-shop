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
            'value' => array(
                    '0'  => array('White'),
                    '1'  => array('Black'),
                    '2'    => array('Red'),
                    '3'   => array('Blue'),
                    '4'  => array('Green'),
                    '5' => array('Yellow'),
                    '6' => array('Purple'),
                    '7'  => array('Brown'),
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
            'value' => array(
                    '0'     => array('XS'),
                    '1'      => array('S'),
                    '2'      => array('M'),
                    '3'      => array('L'),
                    '4'     => array('XL'),
            )
    )
));

$installer->endSetup();
