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

    /*
     * function to return simple products ids by using array
     * of their skus
     * 
     * return array of products ids   
     */

    public function prepareShirtIds($products)
    {
        $counter = 1;
        $ids = array();
        $configs = $this->getShirtsSkus($products);
        foreach ($configs as $config) {
            foreach ($config as $sku) {
                $id = Mage::getModel('catalog/product')->getIdBySku($sku);
                array_push($ids, $id);
            }
            $configs[$counter] = $ids;
            $counter++;
            unset($ids);
            $ids = array();
        }
        return $configs;
    }

    /*
     * function to return array of each config product with 
     * its simple products skus
     * Ex as following : 
     * [2]=>
      array(6) {
      [0]=>
      string(16) "10002-offwhite-s"
      [1]=>
      string(16) "10002-offwhite-m"
      [2]=>
      string(16) "10002-offwhite-l"
      [3]=>
      string(20) "10002-darkcharcoal-s"
      [4]=>
      string(20) "10002-darkcharcoal-m"
      [5]=>
      string(20) "10002-darkcharcoal-l"
      }
     * 
     * @return  array of products skus with respect of their 
     * config products
     */

    private function getShirtsSkus($products)
    {
        $counter = 1;
        $skus = array();
        $varients = array();
        foreach ($products['products'] as $productData) {
            foreach ($productData['variants'] as $simple) {
                array_push($varients, $simple['sku']);
            }
            $skus[$counter] = $varients;
            $counter++;
            unset($varients);
            $varients = array();
        }

        return $skus;
    }

    function formatPeriod($endtime, $starttime)
    {
        $duration = $endtime - $starttime;
        $hours = (int) ($duration / 60 / 60);
        $minutes = (int) ($duration / 60) - $hours * 60;
        $seconds = (int) $duration - $hours * 60 * 60 - $minutes * 60;

        return ($hours == 0 ? "00" : $hours) . ":" . ($minutes == 0 ? "00" : ($minutes < 10 ? "0" . $minutes : $minutes)) . ":" . ($seconds == 0 ? "00" : ($seconds < 10 ? "0" . $seconds : $seconds));
    }

}
