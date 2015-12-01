<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TeeShop_Import_Model_Attributes
{

    const ATTRIBUTE_COLOUR = 'color';
    const ATTRIBUTE_PRIMARY_COLOUR = 'primary_colour';
    const ATTRIBUTE_SIZE = 'size';
    const ATTRIBUTE_BRAND = 'brand';

    static $updatesCount = 0;

    /*
     * function to return number of updates 
     * @return number of updates took place 
     */

    public function getUpdatesCount()
    {
        return static::$updatesCount;
    }

    /*
     * function to add option values to selected attributes
     * 
     * @param array of data imported
     * @return boolean
     */

    public function prepareAttrOptions($products)
    {

        $attributes = array(
            self::ATTRIBUTE_BRAND,
            self::ATTRIBUTE_COLOUR,
            self::ATTRIBUTE_PRIMARY_COLOUR,
            self::ATTRIBUTE_SIZE
        );

        foreach ($attributes as $attribute) {
            $attributeModel = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attribute);
            switch ($attribute) {
                case self::ATTRIBUTE_BRAND:
                    $options = $this->getBrands($products);
                    $this->saveOptions(self::ATTRIBUTE_BRAND, $options);
                    break;
                case self::ATTRIBUTE_SIZE:
                    $options = $this->getSizes($products);
                    $this->saveOptions(self::ATTRIBUTE_SIZE, $options);
                    break;
                case self::ATTRIBUTE_PRIMARY_COLOUR:
                    $options = $this->getPrimaryColours($products);
                    $this->saveOptions(self::ATTRIBUTE_PRIMARY_COLOUR, $options);
                    break;
                case self::ATTRIBUTE_COLOUR:
                    $options = $this->getColours($products);
                    $this->saveOptions(self::ATTRIBUTE_COLOUR, $options);
                    break;
            }
            unset($data);
            unset($options);
        }

        return true;
    }

    /*
     * function to add 1 option value to specific attribute
     * it skips option if it was already installed 
     * 
     * @param $argAttribute is attribute's code
     * @param $argValue     is option's value
     */

    private function addAttributeOption($argAttribute, $argValue)
    {
        $attributeModel = Mage::getModel('eav/entity_attribute');
        $attributeOptionsModel = Mage::getModel('eav/entity_attribute_source_table');

        $attributeCode = $attributeModel->getIdByCode('catalog_product', $argAttribute);
        $attribute = $attributeModel->load($attributeCode);

        $attributeTable = $attributeOptionsModel->setAttribute($attribute);
        $options = $attributeOptionsModel->getAllOptions(false);
        $labels = $this->filterOptions($options);
        if (!in_array($argValue, $labels)) {
            $value['option'] = array($argValue, $argValue);
            $result = array('value' => $value);
            $attribute->setData('option', $result);
            $attribute->save();
            static::$updatesCount++;
        }
    }

    /*
     * function to get only attribute's option label
     * 
     * @param $array array of istalled options 
     * as option id and label
     * 
     * @return $labels array of only preinstalled options
     * labels 
     */

    private function filterOptions($array)
    {
        $labels = array();
        foreach ($array as $key => $value) {
            array_push($labels, $value['label']);
        }
        return $labels;
    }

    private function saveOptions($attributeCode, $options)
    {
        foreach ($options as $option) {
            $this->addAttributeOption($attributeCode, $option);
        }
    }

    /*
     * This function gets colours from product json document& ignore 
     * duplicated colours and create assosiative array to be used as
     * options of "color" attribute 
     * 
     * @return $colour : assostive array contains color options
     * 
     */

    private function getColours($productData)
    {
        $colours = array();
        foreach ($productData['products'] as $product) {
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

    private function getPrimaryColours($productData)
    {
        $primaryColours = array();
        foreach ($productData['products'] as $product) {
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

    private function getSizes($productData)
    {
        $sizes = array();
        foreach ($productData['products'] as $product) {
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

    private function getBrands($productData)
    {
        $brands = array();
        foreach ($productData['products'] as $product) {
            if (!in_array($product["brand"], $brands)) {
                array_push($brands, $product["brand"]);
            }
        }
        // convert it to assositive array
        $index = range(0, count($brands) - 1, 1);
        $brands = array_combine($index, $brands);
        return $brands;
    }

}
