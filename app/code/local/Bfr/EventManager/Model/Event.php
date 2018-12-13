<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Event
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Event extends Mage_Core_Model_Abstract
{
	private $_product = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/event');
    }
    
    
    public function getProduct()
    {
    	if($this->_product == null)
    	{
    		if($this->getProductId()){
    			$this->_product = Mage::getModel('catalog/product')->load($this->getProductId());
    		}
    	}
    	
    	return $this->_product;
    }

    public function getSignatureImage()
    {
        return Mage::helper('eventmanager')->getSignaturePath() . DS . $this->getSignatureFilename();
    }
    
}
