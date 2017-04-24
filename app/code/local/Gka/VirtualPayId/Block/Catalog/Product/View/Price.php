<?php

/**
 * 
 * @author h.koegel
 *
 */
class Gka_VirtualPayId_Block_Catalog_Product_View_Price extends Mage_Catalog_Block_Product_View_Type_Virtual
{
	protected $_kassenzeichen = null;
	
	public function fetchPrice($kz)
	{
		$this->_kassenzeichen = $kz;
		if(!empty($kz)){
			$this->setTemplate('gka/virtualpayid/catalog/product/view/price.phtml');
		}else{
			$this->setTemplate('gka/virtualpayid/catalog/product/view/pricemanual.phtml');
		}
		
		return $this;
	}
	
	
	
	
	
	
	
}
