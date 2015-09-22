<?php
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
 
}