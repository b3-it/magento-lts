<?php
class TuChemnitz_Voucher_Block_Adminhtml_Catalog_Product_Edit_Tab_Voucher
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
    public function xgetTabUrl() {
    	return $this->getUrl('*/voucher_product_edit/form', array('_current' => true));
    }

    /**
     * Get tab class
     *
     * @return string
     */
    public function xgetTabClass()
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
    	return Mage::helper('tucvoucher')->__('Voucher Information');
    }

    /**
     * Get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
    	return Mage::helper('tucvoucher')->__('Voucher Information');
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
    	return ($this->getProduct()->getId() == 0);
    	//return false;
    }
    
  
    
   protected function _toHtml()
    {
    	$grid = $this->getLayout()->createBlock('tucvoucher/adminhtml_catalog_product_edit_tab_voucher_grid');
    	$form = $this->getLayout()->createBlock('tucvoucher/adminhtml_catalog_product_edit_tab_voucher_form');
    	
    	
    
    	$html =  $form->toHtml() . " " .$grid->toHtml()." " ;
    	return $html;
    }
}
