<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Paymentfilter
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
    */
class CamelCase_Tee_Model_Observer {
 
    public function paymentMethodIsActive($observer) {
        
        $event           = $observer->getEvent();
        $method          = $event->getMethodInstance();
        $result          = $event->getResult();
        
            if($method->getCode() == 'checkmo' ){
                $result->isAvailable = true;
            }else{
                $result->isAvailable = false;
            }
    }
    
    public function setLayout($observer)
    {
        Mage::getDesign()->setArea('frontend') 
            ->setPackageName('bare') 
            ->setTheme('default'); 
    }
 
}