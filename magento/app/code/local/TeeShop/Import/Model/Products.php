<?php

class TeeShop_Import_Model_Products 
{
    const PRODUCTS_URL = 'http://fulfilment-service.zhibek.com/product';
    
    public static $instance;
    
    /**
     * Returns the *Products* instance of this class.
     *
     * @return Products The *Products* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Products* via the `new` operator from outside of this class.
     */
    private function __construct()
    {
        $string = file_get_contents(self::PRODUCTS_URL);
        $content = json_decode($string, true);
        $this->instance = $content;
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

}