<?php

class Egovs_Informationservice_Block_Adminhtml_Request_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        //$this->_blockGroup = 'informationservice';
        //$this->_controller = 'adminhtml_extstock';
        
       // $this->_updateButton('save', 'label', Mage::helper('extstock')->__('Save Stock Order'));
       // $this->_updateButton('delete', 'label', Mage::helper('extstock')->__('Delete Stock Order'));
		$this->removeButton('delete');
		$this->removeButton('add');
		$this->removeButton('reset');
		$this->removeButton('back');
		$this->removeButton('save');
		$this->_addButton('close', array(
            'label'   => Mage::helper('catalog')->__('Close'),
            'onclick' => "window.close();",
        	),0,1000);


    }

    public function getHeaderText()
    {
    	return Mage::helper('informationservice')->__('View Task');
    }
   
    protected function _prepareLayout()
    {
        $this->setChild('form', $this->getLayout()->createBlock('informationservice/adminhtml_request_edit_tab_task'));
        return parent::_prepareLayout();
    }
}