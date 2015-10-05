<?php

class CamelCase_Tee_Helper_Data extends Mage_Core_Helper_Abstract {

//    to create an object ->  $helper = Mage::helper('tee');
    public function getAttributeOptionValue($arg_attribute, $arg_value) {
        $attribute_model = Mage::getModel('eav/entity_attribute');
        $attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

        $attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
        $attribute = $attribute_model->load($attribute_code);

        $attribute_table = $attribute_options_model->setAttribute($attribute);
        $options = $attribute_options_model->getAllOptions(false);

        foreach ($options as $option) {
            if ($option['label'] == $arg_value) {
                return $option['value'];
            }
        }

        return false;
    }

}
