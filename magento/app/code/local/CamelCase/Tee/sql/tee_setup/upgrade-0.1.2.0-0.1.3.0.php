
<?php

// make bare theme is the default theme

$installer = $this;
$installer->startSetup();

$config = new Mage_Core_Model_Config();
$config->saveConfig('design/package/name', "bare", 'default', 0);
$config->saveConfig('design/theme/skin', "", 'default', 0);
$config->saveConfig('design/theme/default', "default", 'default', 0);


$installer->endSetup();
