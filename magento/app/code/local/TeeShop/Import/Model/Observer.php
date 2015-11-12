<?php


class TeeShop_Import_Model_Observer
{

	public function processImport($schedule)
	{
		$import = Mage::getModel('importexport/import');
		/* @var $import Mage_ImportExport_Model_Import */
		$import->setEntity('catalog_product');
		$file = Mage::getStoreConfig('teeshop_import/general/file');

		if ($file && file_exists($file))
		{
			$validationResult = $import->validateSource($file);
			if ($import->getProcessedRowsCount() > 0)
			{
				if (!$validationResult)
				{
					$message = sprintf("File %s contains %s corrupt records (from a total of %s)",
									$file, $import->getInvalidRowsCount(), $import->getProcessedRowsCount()
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
	}

}
