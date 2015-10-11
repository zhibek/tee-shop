<?php

class CamelCase_Tee_Helper_Data extends Mage_Core_Helper_Abstract
{

    
    const ATTRIBUTE_PRIMARY_COLOUR = 'primary_colour';
    const ATTRIBUTE_SIZE = 'size';

    //  to create an object ->  $helper = Mage::helper('tee');
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
}
