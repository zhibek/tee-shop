<?php

$helper = Mage::helper('import');
$entityTypeId = Mage::getModel('catalog/product')
        ->getResource()
        ->getEntityType()
        ->getId(); //product entity type
$attributeSetName = 'Default';
$attributeSetId = $this->getAttributeSetId($entityTypeId, $attributeSetName);
$categoryId = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

// primary_colour attribute_id
$primaryColourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Import_Helper_Data::ATTRIBUTE_PRIMARY_COLOUR);
// color attribute_id
$colourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Import_Helper_Data::ATTRIBUTE_COLOUR);
// size attribute_id
$sizeId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Import_Helper_Data::ATTRIBUTE_SIZE);
// brand attribute_id
$brandId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', TeeShop_Import_Helper_Data::ATTRIBUTE_BRAND);

$content = TeeShop_Import_Model_Products::getInstance();

// array of config and their simples
$simples = $helper->prepareShirtIds();

$counter = 1;
foreach ($content->instance['products'] as $productData) {
    Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
    $configProduct = Mage::getModel('catalog/product');
    $configProduct
            ->setWebsiteIds(array(1))
            ->setAttributeSetId($configProduct->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
            ->setTypeId('configurable') //product type
            ->setCreatedAt(strtotime('now')) //product creation time
            ->setSku('Base ' . $productData['title']) //SKU
            ->setName('Base ' . $productData['title']) //product name
            ->setWeight(4.0000)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) //product status (1 - enabled, 2 - disabled)
            ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
            ->setPrice($productData['price']) //price in form 11.22
            ->setMetaTitle('Base ' . $productData['title'])
            ->setMetaKeyword('Base ' . $productData['title'])
            ->setMetaDescription('Base ' . $productData['title'])
            ->setDescription('Base ' . $productData['title'])
            ->setShortDescription('Base ' . $productData['title'])
            ->setBrand($helper->getBrandOptionValue($productData['brand']))
            ->setFabricCare($productData['fabric_care'])
            ->setStockData(array(
                'manage_stock' => 1, //manage stock
                'is_in_stock' => 1, //Stock Availability
                'qty' => 0,
                'use_config_manage_stock' => 0, //'Use config settings' checkbox
                    )
    )
            ->setCategoryIds(array($helper->prepareCategories($productData['categories'][0]))); //assign product to categories

    $configProduct->getTypeInstance()->setUsedProductAttributeIds(array($primaryColourId, $colourId, $sizeId)); //attribute ID of attribute 'primary_colour' in my store
    $simpleIds = $simples[$counter];
    //// loading collection of our shirts
    $simpleProducts = Mage::getResourceModel('catalog/product_collection')
            ->addIdFilter($simpleIds)
            ->addAttributeToSelect('primary_colour')
            ->addAttributeToSelect('color')
            ->addAttributeToSelect('size');
    $configurableProductsData = array();
    $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();

    foreach ($simpleProducts as $simple) {

        $configurableProductsData[$simple->getId()] = $simple;
        $configurableAttributesData[0]['values'][] = $simple;
    }

    $configProduct->setConfigurableProductsData($configurableProductsData);
    $configProduct->setConfigurableAttributesData($configurableAttributesData);
    $configProduct->save();
    
    $counter++;
    unset($simpleIds);
    unset($configurableProductsData);
}