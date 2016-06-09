<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Participant
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Participant extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/participant');
    }
    
    
    
    protected function _afterSave()
    {
    	$this->_saveAttribute('industry',Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY);
    	$this->_saveAttribute('lobby',Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY);
    	
    	return parent::_afterSave();
    }
    
    protected function _afterLoad()
    {
    	$this->getResource()->loadAttribute($this, 'industry',Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY);
    	$this->getResource()->loadAttribute($this, 'lobby',Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY);
    	
    	return parent::_afterLoad();
    }
    
    protected function _saveAttribute($field, $key)
    {
    	$orig = $this->getResource()->getAttributeValues($this->getId(), $key);
    	$data =  $this->getData($field);
    	
    	if(!is_array($orig)){
    		$orig = array();
    	}
    	
    	if(!is_array($data)){
    		$data = array();
    	}
    	
    	$delete= array_diff($orig,$data);
    	$insert= array_diff($data,$orig);
    	
    	$this->getResource()->deleteAttribute($this->getId(), $delete);
    	$this->getResource()->saveAttribute($this->getId(),$insert);
    	
    	return $this;
    	
    }
}
