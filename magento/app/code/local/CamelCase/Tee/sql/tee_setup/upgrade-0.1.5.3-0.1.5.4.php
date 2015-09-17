<?php

$configProduct = Mage::getModel('catalog/product');
$entityTypeId = Mage::getModel('catalog/product')
        ->getResource()
        ->getEntityType()
        ->getId(); //product entity type
$attributeSetName = 'Set-t-shirt';
$attributeSetId = $this->getAttributeSetId($entityTypeId, $attributeSetName);
$category_id = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', 'Test products')
                ->getFirstItem()->getId();

$colourId = (int)Mage::getResourceModel('eav/entity_attribute')
        ->getIdByCode('catalog_product', 'primary-colour');

$sizeId = (int)Mage::getResourceModel('eav/entity_attribute')
        ->getIdByCode('catalog_product', 'size');
try {
    $configProduct
//    ->setStoreId(1) //you can set data in store scope
            ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
            ->setAttributeSetId($attributeSetId) //ID of a attribute set named 'default'
            ->setTypeId('configurable') //product type
            ->setCreatedAt(strtotime('now')) //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time
            ->setSku('config-t-shirt-002') //SKU
            ->setName('config-t-shirt_2') //product name
            ->setWeight(4.0000)
            ->setStatus(1) //product status (1 - enabled, 2 - disabled)
            ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
            ->setPrice(11.22) //price in form 11.22
            ->setCost(22.33) //price in form 11.22
            ->setMetaTitle('test meta title 2')
            ->setMetaKeyword('test meta keyword 2')
            ->setMetaDescription('test meta description 2')
            ->setDescription('Long conf description')
            ->setShortDescription('Short conf description')
            ->setStockData(array(
                'is_in_stock' => 1, //Stock Availability
                'qty' => 999 //qty
                    )
            )
            ->setCategoryIds(array($category_id)) //assign product to categories
    ;
    /**/
    /** assigning associated product to configurable */
    /**/
    $configProduct->getTypeInstance()->setUsedProductAttributeIds(array(137, 138)); //attribute ID of attribute 'color' in my store
    $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();
    
    $configProduct->setCanSaveConfigurableAttributes(true);
    $configProduct->setConfigurableAttributesData($configurableAttributesData);

    $configurableProductsData = array();
    $configurableProductsData['10'] = array(//['10'] = id of a simple product associated with this configurable
        '0' => array(
            'label' => 'primary-colour', //attribute label
            'attribute_id' => $colourId, //attribute ID of attribute 'color' in my store
            'value_index' => '0', //value of 'Green' index of the attribute 'color'
            'is_percent' => '0', //fixed/percent price for this option
            'pricing_value' => '' //value for the pricing
        ),
        '1' => array(
            'label' => 'size', //attribute label
            'attribute_id' => $sizeId, //attribute ID of attribute 'color' in my store
            'value_index' => '0', //value of 'Green' index of the attribute 'color'
            'is_percent' => '0', //fixed/percent price for this option
            'pricing_value' => '' //value for the pricing
        )
    );
    $configProduct->setConfigurableProductsData($configurableProductsData);
    $configProduct->save();

    echo 'success';
} catch (Exception $e) {
    Mage::log($e->getMessage());
    echo $e->getMessage();
}