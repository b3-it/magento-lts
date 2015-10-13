<?php

class Stala_Abo_Block_Adminhtml_Extstock_Grid extends Egovs_Extstock_Block_Adminhtml_Extstock_Grid
{



	protected function _prepareCollection()
	{

		$collection = Mage::getResourceModel('extstock/extstock_collection');
		$this->setCollection($collection);

		$productid = $this->_product_id;//Mage::getSingleton('adminhtml/session')->getData('extstockproduct'); 
		if(!$this->_isStockMode())
		{
			if (!is_null($productid)) {
				$collection->getSelect()->where("product_id = $productid");
			} else {
				$collection->getSelect()->where("product_id IS NULL");
			}
		} else {
			//Wichtig für Redirect von extstocklist mit Filterung!!
			if (!is_null($this->_product_id)) {
				$collection->getSelect()->where("product_id = $this->_product_id");
			}
			if (!is_null($this->_distributor)) {
				//Leerzeichen Rückcodieren #371
				$this->_distributor = str_ireplace("%20", " ", $this->_distributor);
				$collection->getSelect()->where("`distributor` like '$this->_distributor' ");
			}
		}	
		$collection->getSelect()->where("is_abo=0");
		return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();		
	}
	

}