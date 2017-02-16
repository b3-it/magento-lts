<?php
class B3it_ConfigCompare_Block_Adminhtml_Import_Data extends Mage_Adminhtml_Block_Widget_Form_Container 
{

	public function __construct()
	{
		parent::__construct();
		 
		$this->_objectId = 'id';
		$this->_blockGroup = 'dwd_abo';
		$this->_controller = 'adminhtml_abo';
	
		$this->_updateButton('save', 'label', Mage::helper('dwd_abo')->__('Save Item'));
		$this->_updateButton('delete', 'label', Mage::helper('dwd_abo')->__('Delete Item'));
	
		
	
		$this->removeButton('delete');
	}
  
    
   protected function _toHtml()
    {
    	
    	$grid = $this->getLayout()->createBlock('configcompare/adminhtml_import_data_grid');
    	$form = $this->getLayout()->createBlock('configcompare/adminhtml_import_data_form');
    	$url = $this->getUrl("adminhtml/configcompare_import_coreconfigdata",array('_current'=>true));
    	$html =  '<form enctype="multipart/form-data" method="POST" action="'.$url.'" > <div><input name="form_key" type="hidden" value="'.
    	Mage::getSingleton('core/session')->getFormKey().'" /></div>'.$form->toHtml() . "</form> " .$grid->toHtml()." " ;
    	return $html;
    }
}
