<?php

class TeeShop_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{

    //  to create an object ->  $helper = Mage::helper('tee');

    const PRODUCTS_DATA_URL = 'http://fulfilment-service.zhibek.com/product';
    const ATTRIBUTE_PRIMARY_COLOUR = 'primary_colour';
    const ATTRIBUTE_SIZE = 'size';
    const ATTRIBUTE_BRAND = 'brand';
    const ATTRIBUTE_FABRIC_CARE = 'fabric_care';
    const ROOT_STORE_ID = 0;    // used to create root categories

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
     * @param string $argAttribute  -> attribute_code   
     * @param string $argValue  -> option value needed to get its Id
     * 
     * @return int id of the option itself 
     */

    private function getAttributeOptionValue($argAttribute, $argValue)
    {
        $attributeModel = Mage::getModel('eav/entity_attribute');
        $attributeOptionsModel = Mage::getModel('eav/entity_attribute_source_table');

        $attributeCode = $attributeModel->getIdByCode('catalog_product', $argAttribute);
        $attribute = $attributeModel->load($attributeCode);

        $attributeTable = $attributeOptionsModel->setAttribute($attribute);
        $options = $attributeOptionsModel->getAllOptions(false);

        foreach ($options as $option) {
            if ($option['label'] == $argValue) {
                return $option['value'];
            }
        }

        return false;
    }

    /*
     * gives back the id of each option of primary_colour attribute 
     * which used to set primary colour for simple shirts 
     * 
     * @param string  $value : is the name of the attribute option
     * 
     * @return  the id of the option itself 
     */

    public function getPrimaryColourOptionValue($value)
    {
        return $this->getAttributeOptionValue(self::ATTRIBUTE_PRIMARY_COLOUR, $value);
    }

    /*
     * gives back the id of each option value of size attribute
     * which used to set size for simple shirts
     * 
     * @param string  $value : is the name of the attribute option
     * 
     * @return  the id of the option itself 
     */

    public function getSizeOptionValue($value)
    {
        return $this->getAttributeOptionValue(self::ATTRIBUTE_SIZE, $value);
    }

    /*
     * gives back the id of each option value of size attribute
     * which used to set size for simple shirts
     * 
     * @param string  $value : is the name of the attribute option
     * 
     * @return  the id of the option itself 
     */

    public function getBrandOptionValue($value)
    {
        return $this->getAttributeOptionValue(self::ATTRIBUTE_BRAND, $value);
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
     * This function gets colours from product json document& ignore 
     * duplicated colours and create assosiative array to be used as
     * options of "color" attribute 
     * 
     * @return $colour : assostive array contains color options
     * 
     */

    public function getColours()
    {
        $string = file_get_contents(self::PRODUCTS_DATA_URL);
        $content = json_decode($string, true);
        $colours = array();
        foreach ($content['products'] as $product) {
            foreach ($product['variants'] as $simple) {
                if (!in_array($simple['colour'], $colours)) {
                    array_push($colours, $simple['colour']);
                }
            }
        }
        // convert it to assositive array
        $index = range(0, count($colours) - 1, 1);
        $colours = array_combine($index, $colours);
        return $colours;
    }

    /*
     * This function gets primary colours from product json document& ignore 
     * duplicated primary colours and create assosiative array to be used as
     * options of "primary_colour" attribute 
     * 
     * @return $primaryColours : assostive array contains primary colour options
     * 
     */

    public function getPrimaryColours()
    {
        $string = file_get_contents(self::PRODUCTS_DATA_URL);
        $content = json_decode($string, true);
        $primaryColours = array();
        foreach ($content['products'] as $product) {
            foreach ($product['variants'] as $simple) {
                if (!in_array($simple["primary_colour"], $primaryColours)) {
                    array_push($primaryColours, $simple["primary_colour"]);
                }
            }
        }
        // convert it to assositive array
        $index = range(0, count($primaryColours) - 1, 1);
        $primaryColours = array_combine($index, $primaryColours);
        return $primaryColours;
    }

    /*
     * This function gets sizes from product json document& ignore 
     * duplicated sizes and create assosiative array to be used as
     * options of "size" attribute 
     * 
     * @return $sizes : assostive array contains sizes options
     * 
     */
    public function getSizes()
    {
        $string = file_get_contents(self::PRODUCTS_DATA_URL);
        $content = json_decode($string, true);
        $sizes = array();
        foreach ($content['products'] as $product) {
            foreach ($product['variants'] as $simple) {
                if (!in_array($simple["size"], $sizes)) {
                    array_push($sizes, $simple["size"]);
                }
            }
        }
        // convert it to assositive array
        $index = range(0, count($sizes) - 1, 1);
        $sizes = array_combine($index, $sizes);
        return $sizes;
    }
    
    /*
     * This function gets brands from product json document& ignore 
     * duplicated brands and create assosiative array to be used as
     * options of "brand" attribute 
     * 
     * @return $brands : assostive array contains brand options
     * 
     */

    public function getBrands()
    {
        $string = file_get_contents(self::PRODUCTS_DATA_URL);
        $content = json_decode($string, true);
        $brands = array();
        foreach ($content['products'] as $product) {
            if (!in_array($product["brand"], $brands)) {
                array_push($brands, $product["brand"]);
            }
        }
        // convert it to assositive array
        $index = range(0, count($brands) - 1, 1);
        $brands = array_combine($index, $brands);
        return $brands;
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

}
