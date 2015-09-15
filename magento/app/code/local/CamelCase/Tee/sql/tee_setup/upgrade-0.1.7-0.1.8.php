<?php


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
    'user_defined'      => false,
    'default'           => '',
    'searchable'        => true,
    'filterable'        => true,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true
));

$installer->addAttribute('catalog_product', 'fabric-care', array(
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
    'user_defined'      => false,
    'default'           => '',
    'searchable'        => true,
    'filterable'        => true,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true
));

$installer->addAttribute('catalog_product', 'primary-colour', array(
    'group'             => 'General',
    'type'              => 'varchar',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'label'             => 'Primary colour',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => true,
    'user_defined'      => false,
    'default'           => '',
    'searchable'        => true,
    'filterable'        => true,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true,
    'option'            => array(
            'value' => array(
                    'white'  => array('White'),
                    'black'  => array('Black'),
                    'red'    => array('Red'),
                    'blue'   => array('Blue'),
                    'green'  => array('Green'),
                    'yellow' => array('Yellow'),
                    'purple' => array('Purple'),
                    'brown'  => array('Brown'),
            )
    )
));

$installer->addAttribute('catalog_product', 'size', array(
    'group'             => 'General',
    'type'              => 'varchar',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'label'             => 'Size',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => true,
    'user_defined'      => false,
    'default'           => '',
    'searchable'        => true,
    'filterable'        => true,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true,
    'option'            => array(
            'value' => array(
                    'xs'     => array('XS'),
                    's'      => array('S'),
                    'm'      => array('M'),
                    'l'      => array('L'),
                    'xl'     => array('XL'),
            )
    )
));

$installer->endSetup();