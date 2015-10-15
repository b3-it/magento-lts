<?php
class Dwd_Stationen_Block_Adminhtml_Import extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stationen';
        $this->_controller = 'adminhtml_import';
        $this->_mode = '';
        
        $this->_updateButton('save', 'label', Mage::helper('stationen')->__('Import'));
        //$this->_updateButton('delete', 'label', Mage::helper('stationen')->__('Delete Item'));
		
		//$this->_removeButton('save');
		$this->_removeButton('delete');
		$this->_removeButton('back');
		$this->_removeButton('reset');
	/*
		$this->_addButton('customer', array(
            'label'     => Mage::helper('adminhtml')->__('Import'),
            'onclick'   => 'submit()',
            'class'     => 'save',
        ), -100);
		*/
    }

    public function getHeaderText()
    {
    	return Mage::helper('stationen')->__('Import');
      
    }
    
	protected function _prepareLayout()
    {
        if ($this->_blockGroup && $this->_controller ) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_form'));
        }
        return parent::_prepareLayout();
    }
}