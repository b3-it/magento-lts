<?php
/**
 * Egovs Infoletter
 *
 *
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Model_Recipient
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Model_Recipient extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('infoletter/recipient');
    }
    
    
    public function createByCustomer(Mage_Customer_Model_Customer $customer, $queueId)
    {
    	$this->unsetData($this->getIdFieldName());
    	$this->setData('message_id',$queueId);
    	$this->setData('email',$customer->getEmail());
    	$this->setData('prefix',$customer->getPrefix());
    	$this->setData('firstname',$customer->getFirstname());
    	$this->setData('lastname',$customer->getLastname());
    	$this->setData('company',$customer->getCompany());
    	
    	return $this;
    }
}
