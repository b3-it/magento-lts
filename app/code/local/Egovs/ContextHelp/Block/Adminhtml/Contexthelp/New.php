<?php

class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct() {
		parent::__construct();
		 
		$this->_objectId = 'id';
		$this->_blockGroup = 'contexthelp';
		$this->_controller = 'adminhtml_contexthelp';
		$this->_mode = 'new';

		$this->_updateButton('save', 'label', Mage::helper('contexthelp')->__('Continue'));
	}

	protected function _prepareLayout() {
		parent::_prepareLayout();
		 
		return $this;
	}

	public function getHeaderText() {

		return Mage::helper('contexthelp')->__('New Context Help');

	}
}