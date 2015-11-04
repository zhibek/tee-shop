<?php

class TeeShop_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{

    //  to create an object ->  $helper = Mage::helper('tee');

    const ATTRIBUTE_COLOUR = 'color';
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
     * gives back the id of each option of color attribute 
     * which used to set color for simple shirts 
     * 
     * @param string  $value : is the name of the attribute option
     * 
     * @return  the id of the option itself 
     */

    public function getColourOptionValue($value)
    {
        return $this->getAttributeOptionValue(self::ATTRIBUTE_COLOUR, $value);
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
     * gives back the id of each option of Brand attribute 
     * which used to set Brand for simple shirts 
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

}
