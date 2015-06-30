<?php
class CamelCase_Weather_WeatherController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

}