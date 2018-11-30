<?php
/**
 * 
 *  Abstrakte klasse zum speichern der Labels
 *  @category Bkg
 *  @package  Bkg_Tollpolicy_Model_Abstract
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Model_Abstract extends Mage_Core_Model_Abstract
{
	
	protected $_storeid = 0;
	

	
	public function setStoreId($id)
	{
		$this->_storeid = $id;
		return $this;
	}
	
	public function getStoreId()
	{
		return $this->_storeid;
	}
	
	

    
    protected function _afterSave()
    {
    	$obj = new Varien_Object();
    	$labels = $this->getResource()->loadLabels($obj, $this->getId(), $this->getStoreId());
    	
    	
    	$obj->setName($this->getName());
    	$obj->setStoreId($this->getStoreId());
    	$obj->setEntityId($this->getId());
    	 
    	$this->getResource()->saveLabel($obj);
    	 
    	return $this;
    	 
    }
    
    protected function _afterLoad()
    {
    	$obj = new Varien_Object();
    	$labels = $this->getResource()->loadLabels($obj, intval($this->getId()), $this->getStoreId());
    	 
    	
    	$this->setName($obj->getName());
    	
    	 
    	return $this;
    }
    
 
}
