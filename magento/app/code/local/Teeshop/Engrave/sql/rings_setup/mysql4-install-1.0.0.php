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
$attributeName = 'Is Engravable'; // Name of the attribute
$attributeCode = 'is_engravable'; // Code of the attribute
$attributeGroup = 'General';          // Group to add the attribute to
$attributeSetIds = array(4);          // Array with attribute set ID's to add this attribute to. (ID:4 is the Default Attribute Set)
// Configuration:
$data = array(
    'type' => 'int', // Attribute type
    'input' => 'boolean', // Input type
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL, // Attribute scope
    'required' => false, // Is this attribute required?
    'user_defined' => false,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
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
foreach ($attributeSetIds as $attributeSetId) {
    $installer->addAttributeToGroup('catalog_product', $attributeSetId, $attributeGroup, $attributeCode);
}

// Done:
$installer->endSetup();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
Mage::app()->getStore(Mage_Core_Model_App::DISTRO_STORE_ID)->setWebsiteId(1);

$engravedRingRand = mt_rand(1, 9999);
$engravedRing = Mage::getModel('catalog/product');
$engravedRing
        ->setSku('example_sku' . $engravedRingRand) //SKU
        ->setName('Engravable Ring') //product name
        ->setDescription('Very Beautiful Golden Ring with engraved letters, Designed by fabiano carl')
        ->setShortDescription('Ring with engraved letters')
        ->setIsEngravable(1)
        ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
        ->setAttributeSetId(4) //ID of a attribute set named 'default'
        ->setTypeId('simple') //product type
        ->setCreatedAt(strtotime('now')) //product creation time
        ->setWeight(4.0000)
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) //product status (1 - enabled, 2 - disabled)
        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setManufacturer(28) //manufacturer id
        ->setColor(24)
        ->setNewsFromDate('06/26/2014') //product set as new from
        ->setNewsToDate('06/30/2014') //product set as new to
        ->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
        ->setPrice(11.22) //price in form 11.22
        ->setCost(22.33) //price in form 11.22
        ->setSpecialPrice(00.44) //special price in form 11.22
        ->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
        ->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
        ->setMsrpEnabled(1) //enable MAP
        ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
        ->setMsrp(99.99) //Manufacturer's Suggested Retail Price
        ->setCategoryIds(array(4)) //assign product to categories
        ->setStockItem(array(
            'use_config_manage_stock' => 1, //'Use config settings' checkbox
            'manage_stock' => 1, //manage stock
            'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
            'max_sale_qty' => 2, //Maximum Qty Allowed in Shopping Cart
            'is_in_stock' => 1, //Stock Availability
            'qty' => 999 //qty
                )
        )
        ->save();


$normalRingRand = mt_rand(1, 9999);
$normalRing = Mage::getModel('catalog/product');
$normalRing
        ->setSku('example_sku' . $normalRingRand) //SKU
        ->setName('Normal Ring') //product name
        ->setDescription('Very Beautiful Golden Ring without engraved letters, Designed by fabiano carl')
        ->setShortDescription('Ring without engraved letters')
        ->setIsEngravable(0)
        ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
        ->setAttributeSetId(4) //ID of a attribute set named 'default'
        ->setTypeId('simple') //product type
        ->setCreatedAt(strtotime('now')) //product creation time
        ->setWeight(4.0000)
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) //product status (1 - enabled, 2 - disabled)
        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setManufacturer(28) //manufacturer id
        ->setColor(24)
        ->setNewsFromDate('06/26/2014') //product set as new from
        ->setNewsToDate('06/30/2014') //product set as new to
        ->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
        ->setPrice(11.22) //price in form 11.22
        ->setCost(22.33) //price in form 11.22
        ->setSpecialPrice(00.44) //special price in form 11.22
        ->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
        ->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
        ->setMsrpEnabled(1) //enable MAP
        ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
        ->setMsrp(99.99) //Manufacturer's Suggested Retail Price
        ->setCategoryIds(array(4)) //assign product to categories
        ->setStockItem(array(
            'use_config_manage_stock' => 1, //'Use config settings' checkbox
            'manage_stock' => 1, //manage stock
            'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
            'max_sale_qty' => 2, //Maximum Qty Allowed in Shopping Cart
            'is_in_stock' => 1, //Stock Availability
            'qty' => 999 //qty
                )
        )
        ->save();
