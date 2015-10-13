<?php
/**
 * Adminhtml customer freecopies block
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel (http://www.edv-beratung-hempel.de)
 * @copyright	Copyright (c) 2011 TRW-NET (http://www.trw-net.de)
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Freecopiestab extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	protected $_customer = null;
	
	/**
	 * Get current customer
	 * 
	 * @return Mage_Customer_Model_Customer
	 */
	protected function _getCustomer() {
		if (!$this->_customer) {
			$this->_customer = Mage::registry('current_customer');
		}
		
		return $this->_customer;
	}
    /**
     * Initialize block
     *
     */
	public function __construct()
    {
        return parent::__construct();
    }

    /**
     * Retrieve Tab class (for loading)
     *
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax';
    }

    /**
     * Retrieve Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('catalog')->__('Freecopies');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('catalog')->__('Freecopies');
    }

    /**
     * Can show tab flag
     *
     * @return bool
     */
    public function canShowTab()
    {
    	if (is_null($this->_getCustomer())
    		|| $this->_getCustomer()->isEmpty()
    		|| !$this->_getCustomer()->getId()
    		) {
    			return false;
    		}
        return true;
    }

    /**
     * Check is a hidden tab
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
    
    public function getTabUrl() {
    	return $this->getUrl('adminhtml/extcustomer_customer_freecopies', array('_current' => true,'customer_id'=>Mage::registry('current_customer')->getId()));
    }	
}
