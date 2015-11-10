<?php

//Creating a conf product

$configProduct = Mage::getModel('catalog/product');
$entityTypeId = Mage::getModel('catalog/product')
        ->getResource()
        ->getEntityType()
        ->getId(); //product entity type
$attributeSetName = 'Default';
$attributeSetId = $this->getAttributeSetId($entityTypeId, $attributeSetName);
$categoryId = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Men')
                ->getFirstItem()->getId();


// primary_colour attribute_id
$primaryColourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_PRIMARY_COLOUR);
// colour attribute_id
$colourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_COLOUR);
//var_dump($colourId);exit();
// size attribute_id
$sizeId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_SIZE);
// fabric_care attribute_id
$fabricId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_FABRIC_CARE);
// brand attribute_id
$brandId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Catalog_Helper_Data::ATTRIBUTE_BRAND);

Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);

$configProduct
        ->setWebsiteIds(array(1))
        ->setAttributeSetId($configProduct->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
        ->setTypeId('configurable') //product type
        ->setCreatedAt(strtotime('now')) //product creation time
        ->setSku('Base Config Product') //SKU
        ->setName('Base Config Product') //product name
        ->setWeight(4.0000)
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) //product status (1 - enabled, 2 - disabled)
        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setPrice(11.22) //price in form 11.22
        ->setMetaTitle('CONFIG')
        ->setMetaKeyword('CONFIG')
        ->setMetaDescription('CONFIG')
        ->setDescription('Long conf description')
        ->setShortDescription('Short conf description')
        ->setFabricCare('Machine Wash,COLD')
        ->setStockData(array(
            'manage_stock' => 1, //manage stock
            'is_in_stock' => 1, //Stock Availability
            'qty' => 0,
            'use_config_manage_stock' => 0, //'Use config settings' checkbox
                )
);
//        ->setCategoryIds(array($categoryId)); //assign product to categories

$configProduct->getTypeInstance()->setUsedProductAttributeIds(array($primaryColourId, $colourId, $sizeId)); //attribute ID of attribute 'primary_colour' in my store
//getting shirts ids
$simpleIds = array(
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off Black XL')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off Black L')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off Black M')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off Black S')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off Black XS')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off White XL')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off White L')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off White M')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off White S')->getId(),
    Mage::getModel('catalog/product')->loadByAttribute('name', 'T-shirt Off White XS')->getId()
);

// loading collection of our shirts
$simpleProducts = Mage::getResourceModel('catalog/product_collection')
        ->addIdFilter($simpleIds);

$configurableProductsData = array();
$configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();

foreach ($simpleProducts as $simple) {

    $configurableProductsData[$simple->getId()] = $simple;
    $configurableAttributesData[0]['values'][] = $simple;
}

$configProduct->setConfigurableProductsData($configurableProductsData);
$configProduct->setConfigurableAttributesData($configurableAttributesData);
$brand = 'Adidas';
$configProduct->setBrand($helper->getBrandOptionValue($brand));
$configProduct->save();
