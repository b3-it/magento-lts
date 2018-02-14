<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Abstract
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Abstract extends Mage_Core_Model_Abstract
{
   
	protected $_products = null;
	protected $_tolls = null;
	protected $_fees = null;
	protected $_customergroups = null;
	protected $_agreements = null;
    
    public function getLicense($customer,$product,$toll)
    {	
    	return null;
    }
    
    
    /**
     * 
     * @param unknown $resourceName
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _getRelated($resourceName)
    {
    	$collection = Mage::getModel($resourceName)->getCollection();
    	$collection->getSelect()->where('master_id=?',intval($this->getId()));
    	
    	return $collection->getItems();
    }
    
    
    public function getProducts()
    {
    	if($this->_products == null)
    	{
    		$resourceName = $this->_resourceName . '_products';
    		$this->_products = $this->_getRelated($resourceName);
    	}
    	return $this->_products;
    }
    
    public function getTolls()
    {
    	if($this->_tolls == null)
    	{
    		$resourceName = $this->_resourceName . '_toll';
    		$this->_tolls = $this->_getRelated($resourceName);
    	}
    	return $this->_tolls;
    }
    
    public function getCustomerGroups()
    {
    	if($this->_customergroups == null)
    	{
    		$resourceName = $this->_resourceName . '_customergroups';
    		$this->_customergroups = $this->_getRelated($resourceName);
    	}
    	return $this->_customergroups;
    }
    
    public function getFees()
    {
    	if($this->_fees == null)
    	{
    		$resourceName = $this->_resourceName . '_fee';
    		$this->_fees = $this->_getRelated($resourceName);
    	}
    	return $this->_fees;
    }
    
    public function getAgreements()
    {
    	if($this->_agreements == null)
    	{
    		$resourceName = $this->_resourceName . '_agreement';
    		$this->_agreements = $this->_getRelated($resourceName);
    	}
    	return $this->_agreements;
    }
    
    
    public function setProducts($value)
    {
    	$this->_products = $value;
    	return $this->_products;
    }
    
    public function setTolls($value)
    {
    	$this->_tolls = $value;
    	return $this->_tolls;
    }
    
    public function setCustomerGroups($value)
    {
    	$this->_customergroups = $value;
    	return $this->_customergroups;
    }
    
    public function setFees($value)
    {
    	$this->_fees = $value;
    	return $this->_fees;
    }
    
    public function setAgreements($value)
    {
    	$this->_agreements = $value;
    	return $this->_agreements;
    }
 
    
    protected function _saveRelated($collection)
    {
    	if($collection != null){
    		foreach($collection as $item){
    			 $item->setMasterId($this->getId());
    			 $item->save();
    		}
    	}
    }
    
    protected function _afterSave()
    {
    	$this->_saveRelated($this->_products);
    	$this->_saveRelated($this->_tolls);
    	$this->_saveRelated($this->_fees);
    	$this->_saveRelated($this->_customergroups);
    	$this->_saveRelated($this->_agreements);    	
    }
    
    
}
