
<?php

/**
 * Require the Magento abstract class for cli scripts
 * Workaround for varying depths because of possible .modman directory
 */
$path = '/../../../../../../shell/abstract.php';
while (!file_exists(dirname(__FILE__) . $path)) {
    $path = '/..' . $path;
}
require_once dirname(__FILE__) . $path;

/**
 * Shell script to trigger the import of product records from a custom CSV format
 * using the new (1.5) ImportExport module
 */
class TeeShop_Import_Shell_ProductsImport extends Mage_Shell_Abstract
{

    /**
     * Trigger the import
     */
    public function run()
    {
    $import = TeeShop_Import_Model_Data::getInstance();
    $import->setupImportedData();
    }

    
    /**
     * Retrieve usage help message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
        
Usage:  php import.php -- [options]
  --url         link to import from
  -h            Short alias for help
  help          This help

USAGE;
    }

}

$main = new TeeShop_Import_Shell_ProductsImport();
$main->run();
