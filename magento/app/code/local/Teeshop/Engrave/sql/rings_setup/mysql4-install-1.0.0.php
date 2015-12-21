<?php

// This installer scripts adds a category to Magento programmatically.

$parentId = 2; // default category
$category = Mage::getModel('catalog/category');
$category->setName('Rings');
$category->setUrlKey('new-category');
$category->setIsActive(1);
$category->setDisplayMode('PRODUCTS');
$category->setIsAnchor(1); //for active anchor
$category->setStoreId(Mage::app()->getStore()->getId());
$parentCategory = Mage::getModel('catalog/category')->load($parentId);
$category->setPath($parentCategory->getPath());
$category->save();

// This installer scripts adds a product attribute to Magento programmatically.
 
// Set data:
$attributeName  = 'Is Engravable'; // Name of the attribute
$attributeCode  = 'is_engravable'; // Code of the attribute
$attributeGroup = 'General';          // Group to add the attribute to
$attributeSetIds = array(4);          // Array with attribute set ID's to add this attribute to. (ID:4 is the Default Attribute Set)
 
// Configuration:
$data = array(
    'type'      => 'boolean',       // Attribute type
    'input'     => 'checkbox',          // Input type
    'global'    => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,    // Attribute scope
    'required'  => true,           // Is this attribute required?
    'user_defined' => false,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'unique' => false,
    'used_in_product_listing' => true,
    // Filled from above:
    'label' => $attributeName
);
 
// Create attribute:
// We create a new installer class here so we can also use this snippet in a non-EAV setup script.
$installer = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$installer->startSetup();
$installer->addAttribute('catalog_product', $attributeCode, $data);
 
// Add the attribute to the proper sets/groups:
foreach($attributeSetIds as $attributeSetId)
{
    $installer->addAttributeToGroup('catalog_product', $attributeSetId, $attributeGroup, $attributeCode);
}
 
// Done:
$installer->endSetup();
