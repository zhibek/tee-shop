<?php

/*
 * Here we edit Non-user defined attributes
 */

$installer = $this;
$installer->startSetup();
$helper = Mage::helper('tee');
$entityTypeId = Mage::getModel('catalog/product')
        ->getResource()
        ->getEntityType()
        ->getId(); //product entity type
//editing price attribute to appear on search filters
$price = Mage::getSingleton("eav/config")->getAttribute('catalog_product', 'price');
$price->setIsFilterableInSearch(1)->save();

//editting color attribute
$installer->addAttribute('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_COLOUR, array(
    'group'             => 'General',
    'type'              => 'int',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'label'             => 'color',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => true,
    'user_defined'      => false,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'filterable_in_search'  => false,    // to appear in search filters
    'comparable'        => false,
    'visible_on_front'  => true,
    'unique'            => false,
    'apply_to'          => 'simple,configurable',
    'is_configurable'   => true,
    'option'            => array(
            'values' => $helper->getColours()
        )
));

