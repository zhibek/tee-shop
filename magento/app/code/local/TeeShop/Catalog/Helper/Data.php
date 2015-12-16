<?php

class TeeShop_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{

    //  to create an object ->  $helper = Mage::helper('teeshop_catalog');

    const ATTRIBUTE_COLOUR = 'color';
    const ATTRIBUTE_PRIMARY_COLOUR = 'primary_colour';
    const ATTRIBUTE_SIZE = 'size';
    const ATTRIBUTE_BRAND = 'brand';
    const ATTRIBUTE_FABRIC_CARE = 'fabric_care';
    const ROOT_STORE_ID = 0;    // used to create root categories

    protected $productData;

    /* private function to return parent category id
     * 
     * @param string $parentName : parent category's name
     * 
     * @return : parent category id
     */

    private function getParentCatId($parentName)
    {
        return Mage::getResourceModel('catalog/category_collection')
                        ->addFieldToFilter('name', $parentName)
                        ->getFirstItem() // The parent category
                        ->getId();
    }

    /*
     * creates Top level categories
     * 
     * @param string  $topCatName : top category's name
     * 
     * @return : null 
     */

    public function createTopCategory($topCatName)
    {
        $store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
        $category = Mage::getModel('catalog/category');
        $category->setStoreId(self::ROOT_STORE_ID)
                ->setName($topCatName)
                ->setUrlKey($topCatName)
                ->setIsActive(1)
                ->setDisplayMode('PRODUCTS');

        $parentId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
        $parentCategory = Mage::getModel('catalog/category')->load($store->getRootCategoryId());
        $category->setPath($parentCategory->getPath());
        $category->save();
    }

    /*
     * creates subcategories
     * 
     * @param string  $subCatName : subcategory's name
     * @param string  $parentName : Top category's name (parent that to be assigned to)
     * 
     * @return : null 
     */

    public function createSubCategory($subCatName, $parentCatName)
    {
        $category = Mage::getModel('catalog/category');
        $category->setName($subCatName)
                ->setUrlKey($subCatName)
                ->setIsActive(1)
                ->setDisplayMode('PRODUCTS')
                ->setIsAnchor(1)
                ->setCustomDesignApply(1)
                ->setAttributeSetId($category->getDefaultAttributeSetId());

        $parentCategory = Mage::getModel('catalog/category')->load($this->getParentCatId($parentCatName));
        $category->setPath($parentCategory->getPath());

        $category->save();
    }

    /*
     * this function is used to prepare categories ids of 
     * products in json document (for both top level & sub categories)
     * 
     * @param $categories : array of product categories each "top>sub"
     * 
     * @return $categoriesIds : array of ids of both top and sub categories
     */

    public function prepareCategories($categories)
    {
        $categoryIds = array();
        $trace = explode('>', $categories);
        $top = $trace[0];
        $sub = $trace[1];
        $topId = Mage::getResourceModel('catalog/category_collection')
                        ->addFieldToFilter('name', $top)
                        ->getFirstItem()->getId();
        switch ($sub):
            case "Sport":
                $subId = $topId + 1;
                array_push($categoryIds, $topId, $subId);
                break;
            case "Music":
                $subId = $topId + 2;
                array_push($categoryIds, $topId, $subId);
                break;
            case "Art":
                $subId = $topId + 3;
                array_push($categoryIds, $topId, $subId);
                break;
        endswitch;

        return $categoryIds;
    }

    /*
     * Methods of Overriding Mage_Catalog_Model_Layer in TeeShop_Catalog_Model_Layer
     */


    /*
     * This function used to return skus without sizes
     * 
     * @param $product is a product's object
     * 
     * @return sku without size ex: 10017-brightwhite
     */

    public function getSkuWithoutSize($product)
    {
        $skuArray = explode('-', $product->getSku());

        return $skuArray[0] . '-' . $skuArray[1];
    }

    /*
     * This function is used to get one size form each color 
     * and then get id for each product of the filtered products
     * @ param is products array -> null to be used in search too
     * @return array of filter product ids
     */

    public function prepareColourFilteredIds($products = null)
    {
        if (is_null($products)) {
            // getting all products in certain category
            $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addCategoryFilter(Mage::registry('current_category'));
        }
        // contains skus without ids of filtered products
        $tempArray = array();

        // contains skus of filtered products 
        $values = array();
        foreach ($products as $product) {

            /*
             * a way to prevent product with the same color to be 
             * duplicated with another size
             */
            if (!$product->isConfigurable()) {
                if (!in_array($this->getSkuWithoutSize($product), $tempArray)) {
                    array_push($values, $product->getSku());
                    array_push($tempArray, $this->getSkuWithoutSize($product));
                }
            }
        }

        // getting product ids
        $ids = array();
        foreach ($values as $sku) {
            $id = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku)->getId();
            array_push($ids, $id);
        }

        return $ids;
    }

    /*
     * function to get only simple products to use in search
     * 
     * @param collection of products
     * 
     * @return collection of simple products only 
     */

    public function getSimplesOnly($collection)
    {

        foreach ($collection as $pro) {
            if ($pro->isConfigurable()) {
                $collection->removeItemByKey($pro->getId());
            }
            return $collection;
        }
    }

}
