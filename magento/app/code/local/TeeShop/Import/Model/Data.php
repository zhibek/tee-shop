<?php

class TeeShop_Import_Model_Data
{

    const PRODUCTS_URL = 'http://fulfilment-service.zhibek.com/product';

    private static $instance;

    /**
     * Returns the *Products* instance of this class.
     *
     * @return Products The *Products* instance.
     */
    public static function getInstance($url)
    {
        if (null === static::$instance) {
            static::$instance = new static();
            static::$instance->content = TeeShop_Import_Model_Data::storeData($url);
        }
        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Products* via the `new` operator from outside of this class.
     */
    private function __construct()
    {
        
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Products* instance.
     *
     * @return void
     */
    private function __clone()
    {
        
    }

    /**
     * Private unserialize method to prevent unserializing of the *Products*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
        
    }

    private static function storeData($url)
    {
        if ($url == null) {
           $url= self::PRODUCTS_URL; 
        }

        if (TeeShop_Import_Model_Data::is_404($url)) {
            print('Not Found ... please try again later ' . PHP_EOL);
            print('No Products have been imported' . PHP_EOL);
            die();
        }
        else {
            $string = file_get_contents(self::PRODUCTS_URL);
            $content = json_decode($string, true);
            return $content;
        }
    }

    private static function is_404($url)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        /* If the document has loaded successfully without any redirection or error */
        if ($httpCode >= 200 && $httpCode < 300) {
            return false;
        }
        else {
            return true;
        }
    }

    public function setupImportedData()
    {
        $helper = Mage::helper('teeshop_import');
        $attributeStartTime = microtime(true);
        $attrSetup = new TeeShop_Import_Model_Attributes();
        // importing attributes options
        if ($attrSetup->prepareAttrOptions(static::$instance->content)) {
            $attributeEndTime = microtime(true);
            print('Attributes options were imported successfully in ' . $helper->formatPeriod($attributeEndTime, $attributeStartTime) . PHP_EOL);
            print('Report:' . $attrSetup->getUpdatesCount() . ' options were newly imported ' . PHP_EOL);
        }
        else {
            print('Oops..! there was a problem importing attribues options.' . PHP_EOL);
        }

        // importing simple products
        $simpleStartTime = microtime(true);
        $simplesSetup = new TeeShop_Import_Model_Simples();

        if ($simplesSetup->prepareSimples(static::$instance->content)) {
            $simpleEndTime = microtime(true);
            print('Simple products were imported successfully in ' . $helper->formatPeriod($simpleEndTime, $simpleStartTime) . PHP_EOL);
            print('Report:' . $simplesSetup->getUpdatesCount()[0] . ' products exist' . PHP_EOL);
            print('Report:' . $simplesSetup->getUpdatesCount()[1] . ' products were newly imported' . PHP_EOL);
            print('Report:' . $simplesSetup->getUpdatesCount()[2] . ' products were updated successfully' . PHP_EOL);
            print('Report:' . $simplesSetup->getUpdatesCount()[3] . ' products were failed to be updated' . PHP_EOL);
        }
        else {
            print('Oops..! there was a problem importing simple products.' . PHP_EOL);
        }

        // importing configurable products
        $confStartTime = microtime(true);
        $configs = new TeeShop_Import_Model_Configurables();
        if ($configs->prepareConfigs(static::$instance->content)) {
            $confEndTime = microtime(true);
            print('Configurable products were imported successfully in ' . $helper->formatPeriod($confEndTime, $confStartTime) . PHP_EOL);
            print('Report:' . $configs->getUpdatesCount()[0] . ' products exist' . PHP_EOL);
            print('Report:' . $configs->getUpdatesCount()[1] . ' products were newly imported' . PHP_EOL);
            print('Report:' . $configs->getUpdatesCount()[2] . ' products were updated successfully' . PHP_EOL);
            print('Report:' . $configs->getUpdatesCount()[3] . ' products were failed to be updated' . PHP_EOL);
        }
        else {
            print('Oops..! there was a problem importing Configurable products.' . PHP_EOL);
        }
    }

}
