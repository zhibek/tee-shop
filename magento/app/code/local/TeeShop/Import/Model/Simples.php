<?php

class TeeShop_Import_Model_Simples
{

    static $updatesCount = 0;
    static $productsUpdated = 0;
    static $productsCreated = 0;
    static $failedToUpdate = 0;
    protected $helper;

    /*
     * function to return number of updates 
     * @return number of updates took place 
     */

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

    public function prepareSimples($products)
    {
        $oldProducts = $this->getPreInstalledSkus();
        foreach ($products['products'] as $productData) {
            foreach ($productData['variants'] as $simple) {
                if (in_array($simple['sku'], $oldProducts)) {
                    $this->updateProduct($productData, $simple['sku']);
                }
                else {
                    $this->createProduct($productData, $simple['sku']);
                }
            }
        }
        return true;
    }

    private function getPreInstalledSkus()
    {
        $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter(
                'type_id', array('eq' => 'simple')
        );
        $Skus = array();
        foreach ($collection as $product) {
            $Skus[] = $product->getSku();
        }
        return $Skus;
    }

    private function updateProduct($productData, $sku)
    {
        Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);

        // loading product to update it
        $id = Mage::getModel('catalog/product')->getResource()->getIdBySku($sku);
        if ($id) {

            foreach ($productData['variants'] as $simple) {
                if ($simple['sku'] === $sku) {
                    // start updating
                    $updates = array(
                        'name' => $productData['title'].'-'.$simple['primary_colour'],
                        'price' => $productData['price'],
                        'meta_title' => $productData['title'],
                        'meta_keyword' => $productData['title'],
                        'description' => $productData['description'],
                        'short_description' => $productData['description'],
//                        'SKU' => $sku,
                        'weight' => 5,
                        'color' => $this->helper->getColourOptionValue($simple['colour']),
                        'primary_colour' => $this->helper->getPrimaryColourOptionValue($simple['primary_colour']),
                        'size' => $this->helper->getSizeOptionValue($simple['size']),
                        'brand' => $this->helper->getBrandOptionValue($productData['brand']),
                        'fabric_care' => $productData["fabric_care"],
//                        'category_ids' => $this->helper->prepareCategories($productData['categories'][0])
                    );

                    if (Mage::getSingleton('catalog/product_action')->updateAttributes(array($id), $updates, 1)) {
                        static::$updatesCount++;
                        static::$productsUpdated++;
                    }
                    else {
                        static::$failedToUpdate++;
                    }
                }
            }
        }
    }

    private function createProduct($productData, $sku)
    {
        Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
        foreach ($productData['variants'] as $simple) {
            if ($simple['sku'] === $sku) {
                // start creating
                $product = Mage::getModel('catalog/product');
                $product
                        ->setWebsiteIds(array(1))
                        ->setAttributeSetId($product->getDefaultAttributeSetId()) //ID of a attribute set named 'default'
                        ->setTypeId('simple') //product type
                        ->setCreatedAt(strtotime('now')) //product creation time
                        ->setSku($simple['sku']) //SKU
                        ->setName($productData['title'].'-'.$simple['primary_colour']) //product name
                        ->setWeight(4)
                        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
                        ->setPrice($productData['price']) //price in form 11.22
                        ->setMetaTitle($productData['title'])
                        ->setMetaKeyword($productData['title'])
                        ->setMetaDescription($productData['title'])
                        ->setDescription($productData['description'])
                        ->setShortDescription($productData['title'])
                        ->setStockData(array(
                            'is_in_stock' => 1, //Stock Availability
                            'qty' => 100 //qty
                                )
                        )
                        ->setCategoryIds($this->helper->prepareCategories($productData['categories'][0]));
                $product->setColor($this->helper->getColourOptionValue($simple['colour']));
                $product->setPrimaryColour($this->helper->getPrimaryColourOptionValue($simple['primary_colour']));
                $product->setSize($this->helper->getSizeOptionValue($simple['size']));
                $product->setBrand($this->helper->getBrandOptionValue($productData['brand']));
                $product->setFabricCare($productData["fabric_care"]);
                if ($product->save()) {
                    static::$updatesCount++;
                    static::$productsCreated++;
                }
            }
        }
    }

}
