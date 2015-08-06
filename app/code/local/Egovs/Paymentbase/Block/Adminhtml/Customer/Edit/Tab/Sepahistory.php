<?php

/**
 * Customer account form block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Paymentbase_Block_Adminhtml_Customer_Edit_Tab_Sepahistory
 extends Mage_Adminhtml_Block_Widget_Grid_Container
 implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected $_customer;



    
    public function __construct() {
    	$this->_controller = 'adminhtml_customer_edit_tab_sepahistory';
    	$this->_blockGroup = 'paymentbase';
    	$this->_headerText = Mage::helper('paymentbase')->__('SEPA History');
    	
    	parent::__construct();
    	$this->removeButton('add');
    }
    
    
    public function getCustomer()
    {
        if (!$this->_customer) {
            $this->_customer = Mage::registry('current_customer');
        }
        return $this->_customer;
    }



    public function getStoreId()
    {
        return $this->getCustomer()->getStoreId();
    }

 
    public function getTabLabel()
    {
        return Mage::helper('paymentbase')->__('SEPA History');
    }

    public function getTabTitle()
    {
        return Mage::helper('paymentbase')->__('SEPA History');
    }

    public function canShowTab()
    {
        if (Mage::registry('current_customer')->getId()) {
            return $this->hasSEPA();
        }
        return false;
    }

    public function isHidden()
    {
        if (Mage::registry('current_customer')->getId()) {
            return false;
        }
        return true;
    }
    
    private function hasSEPA()
    {
    	return (Mage::helper('paymentbase')->isModuleEnabled('Egovs_SepaDebitBund')); 
    }
    

}
