<?php

class TeeShop_Import_Model_Configurables
{

    static $updatesCount = 0;
    static $productsUpdated = 0;
    static $productsCreated = 0;
    static $failedToUpdate = 0;
    static $associationFlag = 0;
    protected $helper;
    static $counter = 1;

    public function __construct()
    {
        $this->helper = Mage::helper('teeshop_import');
    }

    public function getUpdatesCount()
    {
        return array(
            static::$updatesCount,
            static::$productsCreated,
            static::$productsUpdated,
            static::$failedToUpdate
        );
    }

    public function prepareConfigs($products)
    {
        $oldConfigs = $this->getPreInstalledTitles();

        foreach ($products['products'] as $product) {
            if (in_array('Base ' . $product['title'], $oldConfigs)) {
                $this->updateConfig($products, $product);
            }
            else {
                $this->createConfig($products, $product['title']);
            }
        }
        return true;
    }

    private function getPreInstalledTitles()
    {
        $collection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToFilter('type_id', array('eq' => 'configurable'));
        $titles = array();
        foreach ($collection->getData() as $product) {
            array_push($titles, $product['sku']);
        }
        return $titles;
    }

    private function updateConfig($products, $product)
    {

        Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);

        $id = Mage::getModel('catalog/product')->loadByAttribute('sku', 'Base ' . $product['title'])->getId();

        // loading product to update it
        if ($id) {

            // start updating
            $updates = array(
                'name' => 'Base ' . $product['title'],
                'price' => $product['price'],
                'meta_title' => 'Base ' . $product['title'],
                'meta_keyword' => 'Base ' . $product['title'],
                'description' => 'Base ' . $product['description'],
                'short_description' => 'Base ' . $product['description'],
                'weight' => 5,
                'brand' => $this->helper->getBrandOptionValue($product['brand']),
                'fabric_care' => $product["fabric_care"]
            );

            // configurable product object
            $configProduct = Mage::getModel('catalog/product')->load($id);

//             simple products already assigned to the configurable product
            $oldSimplesAssigned = $this->getOldAssosiatedProducts($configProduct);
            // getting all simples needed to be associated
            $newSimples = $this->getNewAssociatedProducts($products, $product);
//             array of what we need to update in assosoation issue
            $associationUpdates = $this->judgeAssosiationUpdated($oldSimplesAssigned, $newSimples, $configProduct);
//             update association
            if (!(count($associationUpdates["add"]) == 0 && count($associationUpdates['remove']) == 0)) {
                $this->updateAssociation($products, $configProduct);
            }
            if (Mage::getSingleton('catalog/product_action')->updateAttributes(array($id), $updates, 1)) {

                static::$updatesCount++;
                static::$productsUpdated++;
            }
            else {
                static::$failedToUpdate++;
            }
            static::$counter++;
        }
    }

    private function createConfig($products, $configTitle)
    {
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


// array of config and their simples
        $simples = $this->helper->prepareShirtIds($products);

        foreach ($products['products'] as $productData) {
            if ($productData['title'] === $configTitle) {
                Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
                $configProduct = Mage::getModel('catalog/product');
                $configProduct
                        ->setWebsiteIds(array(1))
                        ->setAttributeSetId($configProduct->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
                        ->setTypeId('configurable') //product type
                        ->setCreatedAt(strtotime('now')) //product creation time
                        ->setSku('Base ' . $productData['title']) //SKU
                        ->setPrice($productData['price'])
                        ->setName('Base ' . $productData['title']) //product name
                        ->setWeight(4.0000)
                        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) //product status (1 - enabled, 2 - disabled)
                        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
//                        ->setPrice($productData['price']) //price in form 11.22
                        ->setMetaTitle('Base ' . $productData['title'])
                        ->setMetaKeyword('Base ' . $productData['title'])
                        ->setMetaDescription('Base ' . $productData['title'])
                        ->setDescription('Base ' . $productData['title'])
                        ->setShortDescription('Base ' . $productData['title'])
                        ->setBrand($this->helper->getBrandOptionValue($productData['brand']))
                        ->setFabricCare($productData['fabric_care'])
                        ->setStockData(array(
                            'manage_stock' => 1, //manage stock
                            'is_in_stock' => 1, //Stock Availability
                            'qty' => 0,
                            'use_config_manage_stock' => 0, //'Use config settings' checkbox
                                )
                        )
                        ->setCategoryIds(array($this->helper->prepareCategories($productData['categories'][0]))); //assign product to categories

                $configProduct->getTypeInstance()->setUsedProductAttributeIds(array($primaryColourId, $colourId, $sizeId)); //attribute ID of attribute 'primary_colour' in my store
                $simpleIds = $simples[static::$counter];
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
                if ($configProduct->save()) {
                    static::$updatesCount++;
                    static::$productsCreated++;
                }
                static::$counter++;
                unset($simpleIds);
                unset($configurableProductsData);
            }
        }
    }

    /*
     * This function meant to get array of simple products needed
     * to be assigned to specific config product
     * 
     * @param $products     array of all imported data
     * @param $ConfigData   array of configurable data imported
     * 
     * @return $children    array of simple products needed to be assigned
     */

    private function getNewAssociatedProducts($products, $configData)
    {
        $children = array();

        foreach ($products['products'] as $product) {
            if ($configData['title'] === $product['title']) {
                foreach ($product['variants'] as $simple) {
                    array_push($children, $simple['sku']);
                }
            }
        }
        return $children;
    }

    private function getOldAssosiatedProducts($confProduct)
    {
        $names = array();
        $productIds = $confProduct->getTypeInstance()->getUsedProductIds();
        foreach ($productIds as $id) {
            array_push($names, Mage::getModel('catalog/product')->load($id)->getData()['sku']);
        }
        return $names;
    }

    /*
     * This function meant to judge if the config product need to update 
     * associated products existance or not 
     * if needed it will find the update (remove or new )
     * and react on this decision
     * 
     * @param $oldSimplesAssigned  array of already assigned products 
     * @param $newSimples          array of skus needed to be assigned
     * @param $configProduct       object of configurable product itself
     * 
     * @return $results  array of decisions
     */

    private function judgeAssosiationUpdated($oldSimplesAssigned, $newSimples, $configProduct)
    {
        //array contian simples needed to be unassigned
        $removeSkus = array();
        //array contain new simples
        $newSkus = array();
        //array contain updates
        $updates = array(
            'add' => $newSkus,
            'remove' => $removeSkus
        );

        // checking similarity
        $result = array_diff($oldSimplesAssigned, $newSimples);
        //means no old simples unassigned
        if (count($result) == 0) {
            $result = array_diff($newSimples, $oldSimplesAssigned);
            // means no products needed to be assigned
            if (count($result) == 0) {
                // no update needed
                return $updates;
            }
            else {
                // new products needed to be assigned
                foreach ($result as $new) {
                    array_push($newSkus, $new);
                }
            }
        }
        else {
            //there're products need to be removed 
            foreach ($result as $old) {
                array_push($removeSkus, $old);
            }
        }
        $updates = array(
            'add' => $newSkus,
            'remove' => $removeSkus
        );
        return $updates;
    }
    /*
     * This function meant to update association(add new & remove old)
     * 
     * @param $products         array of products data
     * @param $confProduct      configurable product object 
     */
    private function updateAssociation($products, $confProduct)
    {
        $simples = array();
        // remove all assosiation
        Mage::getResourceSingleton('catalog/product_type_configurable')
                ->saveProducts($confProduct, array());
        
        $confProduct->save();
        
        // VI(Dont edit) : getting fresh copy of the object after unassigning products
        $newConfig = Mage::getModel('catalog/product')->loadByAttribute('sku',$confProduct['sku']);
        // loading simple products to be assigned to newConfig
        foreach ($products['products'] as $product) {
            if ('Base ' . $product['title'] == $newConfig['sku']) {
                foreach ($product['variants'] as $simple) {
                    array_push($simples, Mage::getModel('catalog/product')->loadByAttribute('sku', $simple['sku']));
                }
            }
        }

        $configurableProductsData = array();
        foreach ($simples as $simple) {

            $configurableProductsData[$simple->getId()] = $simple;
        }

        $newConfig->setConfigurableProductsData($configurableProductsData);
        $newConfig->save();
    }

}
