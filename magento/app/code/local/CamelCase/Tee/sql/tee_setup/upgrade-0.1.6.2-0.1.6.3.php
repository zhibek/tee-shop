<?php

$configProduct = Mage::getModel('catalog/product');
$entityTypeId = Mage::getModel('catalog/product')
        ->getResource()
        ->getEntityType()
        ->getId(); //product entity type
$attributeSetName = 'Default';
$attributeSetId = $this->getAttributeSetId($entityTypeId, $attributeSetName);
$category_id = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

$colourId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', 'primary_colour');

$sizeId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', 'size');

$fabricId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', 'fabric_care');

$brandId = (int) Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', 'brand');

$simpleProductToAssign = Mage::getModel('catalog/product')->loadByAttribute('name', 'Test T-Shirt');


try {
    $configProduct
//    ->setStoreId(1) //you can set data in store scope
            ->setWebsiteIds(1) //website ID the product is assigned to, as an array
            ->setAttributeSetId($attributeSetId) //ID of a attribute set named 'default'
            ->setTypeId('configurable') //product type
            ->setCreatedAt(strtotime('now')) //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time
            ->setSku('config Test Product 3 ') //SKU
            ->setName('config Test Product 3') //product name
            ->setWeight(4.0000)
            ->setStatus(1) //product status (1 - enabled, 2 - disabled)
            ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
            ->setPrice(11.22) //price in form 11.22
            ->setMetaTitle('test meta titasdasdale 2')
            ->setMetaKeyword('test meta keyword asdasd2')
            ->setMetaDescription('test meta descriptiosadasdn 2')
            ->setDescription('Long conf descriptioasdsadn')
            ->setShortDescription('Short conf descriptasdasdasdion')
            ->setStockData(array(
                'use_config_manage_stock' => 0, //'Use config settings' checkbox
                'manage_stock' => 1, //manage stock
                'is_in_stock' => 1, //Stock Availability
                'qty' => 999 //qty
                    )
            )
            ->setCategoryIds(array($category_id)) //assign product to categories
    ;
    /**/
    /** assigning associated product to configurable */
    /**/
    $configProduct->getTypeInstance()->setUsedProductAttributeIds(array((int) $colourId, (int) $sizeId)); //attribute ID of attribute 'color' in my store
    $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();

    $configProduct->setCanSaveConfigurableAttributes(true);
    $configProduct->setConfigurableAttributesData($configurableAttributesData);

    $configurableProductsData = array();
    $configurableProductsData[$simpleProductToAssign] = array(
        array(//['10'] = id of a simple product associated with this configurable
            '0' => array(
                'label' => 'primary_colour', //attribute label
                'attribute_id' => $colourId, //attribute ID of attribute 'color' in my store
                'value_index' => 'Black', //value of 'Green' index of the attribute 'color'
                'is_percent' => '0', //fixed/percent price for this option
                'pricing_value' => '' //value for the pricing
            ),
            '1' => array(
                'label' => 'size', //attribute label
                'attribute_id' => $sizeId, //attribute ID of attribute 'color' in my store
                'value_index' => 'L', //value of 'Green' index of the attribute 'color'
                'is_percent' => '0', //fixed/percent price for this option
                'pricing_value' => '' //value for the pricing
            )
        )
    );
    $configProduct->setConfigurableProductsData($configurableProductsData);
    $configProduct->save();

    echo 'success';
} catch (Exception $e) {
    Mage::log($e->getMessage());
    echo $e->getMessage();
}