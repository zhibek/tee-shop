<?php

class TeeShop_Import_Model_Observer
{
    public function import(){
        $updateScript = new TeeShop_Import_Shell_ProductsImport();
        $updateScript->run();
        }
}
