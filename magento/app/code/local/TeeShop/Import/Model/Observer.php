<?php

class TeeShop_Import_Model_Observer
{
    public function import(){
        Mage::log("Importing products at ".now().".....",null,"mycron.log");
        $updateScript = new TeeShop_ProductsImport();
        $updateScript->run();
        }
}
