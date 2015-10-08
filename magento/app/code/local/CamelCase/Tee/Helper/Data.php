<?php

class CamelCase_Tee_Helper_Data extends Mage_Core_Helper_Abstract
{

    CONST ATTRIBUTE_PRIMARY_COLOUR = 'primary_colour';
    CONST ATTRIBUTE_SIZE = 'size';

    public function getPrimaryColourOptionValue($value)
    {
	return $this->getAttributeOptionValue(self::ATTRIBUTE_PRIMARY_COLOUR, $value);
    }

    public function getSizeOptionValue($value)
    {
	return $this->getAttributeOptionValue(self::ATTRIBUTE_SIZE, $value);
    }

//    to create an object ->  $helper = Mage::helper('tee');
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

}
