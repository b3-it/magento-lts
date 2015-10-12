<?php

class Egovs_Informationservice_Block_Adminhtml_Request_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'informationservice';
        $this->_controller = 'adminhtml_request';
        $this->_mode = 'view';
        
		$this->removeButton('delete');
		$this->removeButton('add');
		$this->removeButton('reset');
		$this->removeButton('back');
		$this->removeButton('save');
		$this->addButton('close', array(
            'label'   => Mage::helper('catalog')->__('Close'),
            'onclick' => "window.close();",
        	)
		);
    }

    public function getHeaderText() {
    	return Mage::helper('informationservice')->__('View Task');
    }
}