<?php
class  Sid_Import_Model_Builder_Itw extends B3it_XmlBind_ProductBuilder_Abstract
{
	

	protected $_webSiteId = 1;
	    
	public function getWebSiteId() 
	{
	  return $this->_webSiteId;
	}
	
	public function setWebSiteId($value) 
	{
	  $this->_webSiteId = $value;
	}
	
	
	
	protected $category_id = 3;
	    
	public function getCategoryId() 
	{
	  return $this->category_id;
	}
	
	public function setCategoryId($value) 
	{
	  $this->category_id = $value;
	}
	
	
	private $Los;
	    
	public function getLos() 
	{
	  return $this->Los;
	}
	
	public function setLos($value) 
	{
	  $this->Los = $value;
	}
	
	
	private $Store;
	    
	public function getStore() 
	{
	  return $this->Store;
	}
	
	public function setStore($value) 
	{
	  $this->Store = $value;
	}
	
	
	
	
	
	private $FramecontractQty = 0;
	    
	public function getFramecontractQty() 
	{
	  return $this->FramecontractQty;
	}
	
	public function setFramecontractQty($value) 
	{
	  $this->FramecontractQty = $value;
	}
	
	
	
	
	private $taxRates = array();
	    
	public function getTaxRates() 
	{
	  return $this->taxRates;
	}
	
	public function setTaxRates($value) 
	{
	  $this->taxRates = $value;
	}
	
	
	
	
	
	protected function _getEntityDefaultRow()
	{
		$res = array();
		$res['store_group'] = $this->Store;
		return $res;
	}
	
	protected function _getAttributeDefaultRow()
	{
		$res = array();
		$res['status'] = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
		$res['visibility'] = Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH;
		$res['framecontract_los'] = $this->Los;
		$res['groupscatalog2_groups'] = -1;
		
		$res['default_qty'] = $this->FramecontractQty;

		return $res;
	}
	
	protected function _getTaxClassId($taxRate)
	{
		$taxRate = intval($taxRate);
		if(isset($this->taxRates[$taxRate])){
			return $this->taxRates[$taxRate];
		}
		return 0;
	}
	
	
	public function reindex()
	{
		$indexer = Mage::getResourceModel('catalog/product_indexer_price');
		foreach($this->getAllEntityIds() as $id){
			$indexer->reindexProductIds($id);
		}
	}
	
}
