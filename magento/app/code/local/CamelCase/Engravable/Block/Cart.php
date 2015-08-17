<?php
class CamelCase_Engravable_Block_Cart extends Mage_Core_Block_Template
{

	public function getItem()
	{
		$parent = $this->getParentBlock();
		if ($parent) {
			$item = $parent->getItem();
		}
        return $item;
	}

    public function isEngravableProduct()
    {
        // FIX: $product->load() should be avoided, because it forces the product to be reloaded.
        // This impacts performance.
        // A better way would be to ensure is_engravable is available when the product is first retrieved.
        return (bool)$this->getItem()->getProduct()->load()->getIsEngravable();
    }

    public function getEngravedName()
    {
        return $this->getItem()->getEngravedName();
    }

    public function getEngravedDate()
    {
        return $this->getItem()->getEngravedDate();
    }

}