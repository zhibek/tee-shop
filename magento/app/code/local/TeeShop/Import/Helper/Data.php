<?php

class TeeShop_Import_Helper_Data extends Mage_Core_Helper_Abstract
{

    const ATTRIBUTE_COLOUR = 'color';
    const ATTRIBUTE_PRIMARY_COLOUR = 'primary_colour';
    const ATTRIBUTE_SIZE = 'size';
    const ATTRIBUTE_BRAND = 'brand';

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
     * gives back the id of each option value of color attribute
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
