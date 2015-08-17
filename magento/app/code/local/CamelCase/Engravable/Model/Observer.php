<?php


class CamelCase_Engravable_Model_Observer
{
    public function logNameAndDate($observer)
    {
        $params = Mage::app()->getRequest()->getPost();
        if(!empty($params['engravable_name'])) {
            $date  = date('d-m-Y');
            Mage::log("This an engravable Ring With Name '{$params['engravable_name']}' and date {$date}");
        }
    }
}
