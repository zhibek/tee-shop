<?php

/**
 * Require the Magento abstract class for cli scripts
 * Workaround for varying depths because of possible .modman directory
 */
$path = '/../../../../../../shell/abstract.php';
while (! file_exists(dirname(__FILE__) . $path))
{
    $path = '/..' . $path;
}
require_once dirname(__FILE__) . $path;

/**
 * Shell script to trigger the import of product records from a custom CSV format
 * using the new (1.5) ImportExport module
 */
class TeeShop_Import extends Mage_Shell_Abstract
{
	/**
	 * Trigger the import
	 */
	public function run()
	{
		$import = Mage::getModel('importexport/import');
		/* @var $import Mage_ImportExport_Model_Import */
		$import->setEntity('catalog_product');
		$validationResult = $import->validateSource($this->getFile());
		if ($import->getProcessedRowsCount() > 0)
		{
			if (!$validationResult)
			{
				$message = sprintf("File %s contains %s corrupt records (from a total of %s)",
					$this->getFile(), $import->getInvalidRowsCount(), $import->getProcessedRowsCount()
				);
				foreach ($import->getErrors() as $type => $lines)
				{
					$message .= "\n:::: " . $type . " ::::\nIn Line(s) " . implode(", ", $lines) . "\n";
				}
				Mage::throwException($message);
			}
			$import->importSource();
			$import->invalidateIndex();
		}
	}

	/**
	 * Return the specified source file
	 *
	 * @return string
	 */
	public function getFile()
	{
		$file = $this->getArg('s');
		if (!$file)
		{
			$file = $this->getArg('source');
		}
		if (!$file)
		{
//			$file = Mage::getStoreConfig('teeshop_import/general/file');
            $file = Mage::getBaseDir().'/app/code/local/TeeShop/Import/etc/catalog_product.csv';
		}
		if (!$file)
		{
			die($this->usageHelp());
		}

		return $file;
	}

	/**
	 * Retrieve usage help message
	 *
	 */
	public function usageHelp()
	{
		return <<<USAGE
Usage:  php -f run.php -- [options]

  -s            Path to import file, or
  --source      Path to import file
  -h            Short alias for help
  help          This help

USAGE;
	}

}

$main = new TeeShop_Import();
$main->run();