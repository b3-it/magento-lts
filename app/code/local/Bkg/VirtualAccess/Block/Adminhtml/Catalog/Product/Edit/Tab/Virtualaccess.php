<?php
class Bkg_VirtualAccess_Block_Adminhtml_Catalog_Product_Edit_Tab_Virtualaccess
    extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Reference to product objects that is being edited
     *
     * @var Mage_Catalog_Model_Product
     */
    protected $_product = null;

    protected $_config = null;

    /**
     * Get tab URL
     *
     * @return string
     */
    public function getTabUrl() {
    	return $this->getUrl('adminhtml/virtualaccess_product_edit/form', array('_current' => true));
    }

    /**
     * Get tab class
     *
     * @return string
     */
    public function getTabClass()
    {
    	return 'ajax';
    }

    /**
     * Check is readonly block
     *
     * @return boolean
     */
    public function isReadonly()
    {
    	false;
    }

    /**
     * Retrieve product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
    	return Mage::registry('current_product');
    }

    /**
     * Get tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
    	return Mage::helper('virtualaccess')->__('Configurable Virtual Information');
    }

    /**
     * Get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
    	return Mage::helper('virtualaccess')->__('Configurable Virtual Information');
    }

    /**
     * Check if tab can be displayed
     *
     * @return boolean
     */
    public function canShowTab()
    {
    	return true;
    }

    /**
     * Check if tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
    	return false;
    }
}
