<?php

class Sid_Framecontract_Model_Mysql4_Vendor_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	
	/**
	 * Name prefix of events that are dispatched by model
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'framecontract_vendor_collection';
	
	/**
	 * Name of event parameter
	 *
	 * @var string
	 */
	protected $_eventObject = 'collection';
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/vendor');
    }
}