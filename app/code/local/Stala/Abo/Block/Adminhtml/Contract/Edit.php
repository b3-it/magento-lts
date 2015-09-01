<?php

class Stala_Abo_Block_Adminhtml_Contract_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	protected $_blockGroup = 'stalaabo';
	protected $_controller = 'adminhtml_contract';

	public function __construct()
	{
		parent::__construct();
		 
		$this->_objectId = 'id';

		//$this->_updateButton('save', 'label', Mage::helper('stalaabo')->__('Save Item'));
		$this->_updateButton('delete', 'label', Mage::helper('stalaabo')->__('Delete Contract'));
		$origin = $this->getRequest()->getParam('origin');
		if($origin)
		{
			if($origin=='customer')
			{
				$url = "adminhtml/customer/edit/";
				$this->_updateButton('back', 'onclick',"setLocation('{$this->getUrl($url,array('id'=>$this->getRequest()->getParam('customer_id'),'active_tab'=>'stalaabo_child'))}')");
			}
			else
			{
				$url = "/adminhtml_".$origin."/index/";
				$this->_updateButton('back', 'onclick',"setLocation('{$this->getUrl($url)}')");
			}
		}

	}

	public function getHeaderText()
	{
		if( Mage::registry('contract_data') && Mage::registry('contract_data')->getId() ) {
			return Mage::helper('stalaabo')->__("Show Contract '%s'", $this->htmlEscape(Mage::registry('contract_data')->getId()));
		}
	}

	protected function _beforeToHtml()
	{
		$this->_removeButton('save');
		$this->_removeButton('reset');
	}
}