<?php
/**
 * Adminhtml product cross freecopies block
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel (http://www.edv-beratung-hempel.de)
 * @copyright	Copyright (c) 2011 TRW-NET (http://www.trw-net.de)
 */
class Stala_Extcustomer_Block_Adminhtml_Product_Tabs_Freecopiestab extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	protected $_product = null;
	
	/**
     * Retrive currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
    	if (!$this->_product) {
    		$this->_product = Mage::registry('current_product');
    	}
        return $this->_product;
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
        return Mage::helper('catalog')->__('Cross-Freecopies');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('catalog')->__('Cross-Freecopies');
    }

    /**
     * Can show tab flag
     *
     * @return bool
     */
    public function canShowTab()
    {
    	if (is_null($this->_getProduct())
    		|| $this->_getProduct()->isEmpty()
    		|| !$this->_getProduct()->getId()
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
    	return $this->getUrl('adminhtml/extcustomer_product_freecopies', array('_current' => true,'product_id'=>$this->_getProduct()->getId()));
    }	
}
