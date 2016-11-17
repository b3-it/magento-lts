<?php
class Dwd_Periode_Block_Catalog_Product_View_Select extends Mage_Catalog_Block_Product_View_Abstract
{
	//alle zeiten für ein Produkt als array
	private $_perioden = null;
	
	protected function getPerioden()
	{
		if($this->_perioden == null)
		{
			$this->_perioden = array();
			$product_id = $this->getProduct()->getId();
			if($product_id)
			{
				$collection = Mage::getModel('periode/periode')->getCollection();
				$collection->getSelect()->where('product_id=?', intval($product_id));
				$collection->setStoreId($this->getStoreId());
				foreach ($collection->getItems() as $item)
				{
					$this->_perioden[] = $item;
				}
			}
			
		}
		
		return $this->_perioden;
	}
    
	public function getStoreId()
	{
		return Mage::app()->getStore()->getStoreId();
	}
	
	public function showInfo()
	{
		return count($this->getPerioden()) == 1;
	}
	
	public function showSelect()
	{
		return count($this->getPerioden()) > 1;
	}
	
	public function show()
	{
		return count($this->getPerioden()) > 0;
	}
	
   public function getFormatedPeriodePrice($periode)
   {
   		
   		return Mage::helper('core')->formatPrice($periode->getFinalPrice($this->getProduct()),false);
   }
	
   public function getPrice($periode)
   {
   		$product = $this->getProduct();
   	 return $periode->getFinalPrice($product);
   }
   
   public function getFormatedFinalPrice($periode)
   {
   		$product = $this->getProduct();
   		if($periode->getCustomerTierPrice())
   		{
   			$_price = $periode->getFinalPrice($product);
   		}
   		else
   		{
   			$_price = Mage::helper('tax')->getPrice($product, $product->getPrice());
   			$_price += $periode->getFinalPrice($product);
   		}
   		return Mage::helper('core')->formatPrice($_price,false);
   }
   
 
}