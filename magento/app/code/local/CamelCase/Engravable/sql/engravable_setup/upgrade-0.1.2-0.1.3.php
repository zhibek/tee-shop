<?php

$installer = $this;
$installer->startSetup();

$config = new Mage_Core_Model_Config();
$config->saveConfig('camelcase/engravable/character_price', "0.1", 'default', 0);

$installer->endSetup();

