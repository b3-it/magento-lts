<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Model_Components_Georef_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Virtualgeo_Model_Components_Georef extends Mage_Core_Model_Abstract
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
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_georef');
    }
    
    protected function _afterSave()
    {
    	$obj = new Varien_Object();
    	$labels = $this->getResource()->loadLabels($obj, $this->getId(), $this->getStoreId());
    	
    	$obj->setShortname($this->getShortname());
    	$obj->setName($this->getName());
    	$obj->setDescription($this->getDescription());
    	
    	$obj->setStoreId($this->getStoreId());
    	$obj->setParentId($this->getId());
    	
    	$this->getResource()->saveLabel($obj);
    	
		return $this;
    	
    }
    
    protected function _afterLoad()
    {
    	$obj = new Varien_Object();
    	$labels = $this->getResource()->loadLabels($obj, $this->getId(), $this->getStoreId());
    	
    	$this->setShortname($obj->getShortname());
    	$this->setName($obj->getName());
    	$this->setDescription($obj->getDescription());
    	
    	return $this;
    }
}
