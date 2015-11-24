<?php
// adding our product attributes (fabric_care , primary_colour , size , brand )

$helper = Mage::helper('tee');
$installer = $this;
$installer->startSetup();

$installer->addAttribute('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_BRAND, array(
    'group'                 => 'General',
    'type'                  => 'int',
    'backend'               => '',
    'frontend'              => '',
    'label'                 => 'Brand',
    'input'                 => 'select',     // dropdown attribute
    'class'                 => '',
    'global'                => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'               => true,
    'required'              => false,
    'user_defined'          => true,    // user attribute not system attribute
    'default'               => '',
    'searchable'            => true,
    'visible_in_advanced_search' => true,
    'filterable'            => true,    // can be searched with
    'filterable_in_search'  => true,    // to appear in search filters
    'comparable'            => false,
    'visible_on_front'      => true,    // can be seen in addational information tab in product page
    'unique'                => false,
    'apply_to'              => 'simple,configurable',    // used with both simple and configurable products
    'is_configurable'       => true,
    'option'                => array(
            'values' => $helper->getBrands()
    )
));
$installer->addAttribute('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_FABRIC_CARE, array(
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

$installer->addAttribute('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_PRIMARY_COLOUR, array(
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
    'filterable'        => true,
    'filterable_in_search'  => true,    // to appear in search filters
    'comparable'        => false,
    'visible_on_front'  => true,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true,
    'option'            => array(
            'values' => $helper->getPrimaryColours()
    )
));

$installer->addAttribute('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_SIZE, array(
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
            'values' => $helper->getSizes()
        )
));

$installer->endSetup();
