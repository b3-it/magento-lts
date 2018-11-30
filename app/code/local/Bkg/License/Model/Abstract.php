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
   
	protected $_product = null;
	protected $_tolls = null;
	protected $_fees = null;
	protected $_customergroup = null;
	protected $_agreements = null;
    
    public function getLicense($customer,$product,$toll)
    {	
    	return null;
    }
    
    
    /**
     * 
     * @param string $resourceName
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _getRelated($resourceName)
    {
    	$collection = Mage::getModel($resourceName)->getCollection();
    	$collection->getSelect()->where('master_id=?',intval($this->getId()));
    	
    	return $collection->getItems();
    }
    
    
    public function getProduct()
    {
    	if($this->_product == null)
    	{
    		$resourceName = $this->_resourceName . '_product';
    		$this->_product = $this->_getRelated($resourceName);
    	}
    	return $this->_product;
    }
    
    public function getToll()
    {
    	if($this->_tolls == null)
    	{
    		$resourceName = $this->_resourceName . '_toll';
    		$this->_tolls = $this->_getRelated($resourceName);
    	}
    	return $this->_tolls;
    }
    
    public function getCustomergroup()
    {
    	if($this->_customergroup == null)
    	{
    		$resourceName = $this->_resourceName . '_customergroup';
    		$this->_customergroup = $this->_getRelated($resourceName);
    	}
    	return $this->_customergroup;
    }
    
    public function getFee()
    {
    	if($this->_fees == null)
    	{
    		$resourceName = $this->_resourceName . '_fee';
    		$this->_fees = $this->_getRelated($resourceName);
    	}
    	return $this->_fees;
    }
    
    public function getAgreement()
    {
    	if($this->_agreements == null)
    	{
    		$resourceName = $this->_resourceName . '_agreement';
    		$this->_agreements = $this->_getRelated($resourceName);
    	}
    	return $this->_agreements;
    }
    
    
    public function setProduct($value)
    {
    	$this->_product = $value;
    	return $this->_product;
    }
    
    public function setToll($value)
    {
    	$this->_tolls = $value;
    	return $this->_tolls;
    }
    
    public function setCustomergroup($value)
    {
    	$this->_customergroup = $value;
    	return $this->_customergroup;
    }
    
    public function setFee($value)
    {
    	$this->_fees = $value;
    	return $this->_fees;
    }
    
    public function setAgreement($value)
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
    	$this->_saveRelated($this->_product);
    	$this->_saveRelated($this->_tolls);
    	$this->_saveRelated($this->_fees);
    	$this->_saveRelated($this->_customergroup);
    	$this->_saveRelated($this->_agreements);    	
    }
    
    
}
