<?php

$installer = $this;
$installer->startSetup();

$config = new Mage_Core_Model_Config();
$config->saveConfig('design/package/name', "camelcase" , 'default', 0);


$installer->endSetup();
