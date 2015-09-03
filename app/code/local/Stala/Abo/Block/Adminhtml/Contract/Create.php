<?php

class Stala_Abo_Block_Adminhtml_Contract_Create extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
          
        $this->_objectId = 'id';
        //$this->_blockGroup = 'abo';
        ///$this->_mode = 'create';
        //$this->_controller = 'adminhtml_contract';
    
        $this->_updateButton('save', 'label', Mage::helper('stalaabo')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('stalaabo')->__('Delete Item'));

        $this->setTemplate('stala/abo/contract/create.phtml');
    }

    public function getHeaderText()
    {
        if( Mage::registry('contract_data') && Mage::registry('contract_data')->getId() ) {
            return Mage::helper('stalaabo')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('contract_data')->getTitle()));
        } else {
            return Mage::helper('stalaabo')->__('Add Item');
        }
    }
	
    protected function _prepareLayout()
    {
        $this->setChild('product',$this->getLayout()->createBlock('stalaabo/adminhtml_contract_create_product_grid')); 
       	$this->setChild('list',$this->getLayout()->createBlock('stalaabo/adminhtml_contract_create_list')); 
       	$this->setChild('customer',$this->getLayout()->createBlock('stalaabo/adminhtml_contract_create_details')); 
        return Mage_Adminhtml_Block_Widget_Container::_prepareLayout();
    }
    
    public function getSaveUrl()
    {
    	return $this->getUrl('*/*/createPost');
    }
    
  	public function getItemsListUrl()
    {
    	return $this->getUrl('*/*/itemsList');
    }
    
  	public function getItemsAddUrl()
    {
    	return $this->getUrl('*/*/addItems');
    }
    
  	public function getItemsRemoveUrl()
    {
    	return $this->getUrl('*/*/removeItems');
    }
	
}