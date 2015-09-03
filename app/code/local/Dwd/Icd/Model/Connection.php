<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Connection
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Connection extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/connection');
    }
    
    protected function _afterLoad()
    {
    	Mage::dispatchEvent('model_load_after', array('object'=>$this));
    	Mage::dispatchEvent($this->_eventPrefix.'_load_after', $this->_getEventData());
    	$crypt = Mage::getModel('core/encryption');
    	$this->setPassword($crypt->decrypt($this->getPassword()));
    	return $this;
    }
    
    protected function _beforeSave()
    {
    	if (!$this->getId()) {
    		$this->isObjectNew(true);
    	}
    	Mage::dispatchEvent('model_save_before', array('object'=>$this));
    	Mage::dispatchEvent($this->_eventPrefix.'_save_before', $this->_getEventData());
    	$crypt = Mage::getModel('core/encryption');
    	$this->setPassword($crypt->encrypt($this->getPassword()));
    	return $this;
    }
    
}