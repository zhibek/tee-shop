<?php

class CamelCase_Weather_Adminhtml_WeatherbackendController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__("Weather Backend"));

//        $block = Mage::app()->getLayout()
//                ->createBlock("weather/adminhtml_weatherbackend")
////                ->setData('area','frontend')
//                ->setTemplate('weather/weatherbackend.phtml')
//        ;

//        var_dump($block);exit;
//        $this->_addContent($block);
        $this->renderLayout();
    }

}
