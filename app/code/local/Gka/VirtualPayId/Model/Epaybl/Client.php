<?php
/**
 *
 * @category   	Gka Virtualpayid
 * @package    	Gka_VirtualPayId
 * @name       	Gka_VirtualPayId_Model_Epaybl_Client
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_VirtualPayId_Model_Epaybl_Client extends Mage_Core_Model_Abstract
{
	
	protected $_Stores = array();
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualpayid/epaybl_client');
    }
    
    public function getStores()
    {
    	return $this->_Stores;
    }
    
    public function setStores($stores = array())
    {
    	return $this->_Stores =$stores;
    }
    
    
    protected function _beforeSave()
    {
    	$this->setVisibleInStores(implode(',', $this->_Stores));
    }
    
    
    
    protected function _afterLoad()
    {
    	$this->_Stores = explode(',', $this->getVisibleInStores());
    }
}
