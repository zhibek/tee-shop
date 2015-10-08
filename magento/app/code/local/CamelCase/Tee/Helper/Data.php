<?php

#NOTE : Reindexing Values 
//$reindex = Mage::getModel('index/process')->load($value);
//$reindex ->reindexAll();
//
// 1 : Attributes
// 2 : Product Prices
// 3 : Catalog URL Rewrites
// 4 : Product falt data
// 5 : Category Flat Data
// 6 : Category Products
// 7 : Catalog Search Index
// 8 : Stock Status
// 9 : Tag Aggregation Data  



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
