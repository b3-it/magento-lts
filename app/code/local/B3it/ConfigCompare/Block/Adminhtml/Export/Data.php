<?php
class B3it_ConfigCompare_Block_Adminhtml_Export_Data extends Mage_Adminhtml_Block_Widget_Form_Container 
{

	public function __construct()
	{
		//	die('cc');
		parent::__construct();
		 
		$this->_objectId = 'id';
		$this->_blockGroup = 'configcompare';
		$this->_controller = 'adminhtml_import';
		$this->_mode = 'data';
		$this->removeButton('reset');
		$this->removeButton('back');
		$this->removeButton('delete');
	}
  
    
   protected function _toHtml()
    {
    	$form = $this->getLayout()->createBlock('configcompare/adminhtml_export_data_form');
    	$url = $this->getUrl("adminhtml/configcompare_export/export",array('_current'=>true));
    	$html =  '<form enctype="multipart/form-data" method="POST" action="'.$url.'" > <div><input name="form_key" type="hidden" value="'.
    	Mage::getSingleton('core/session')->getFormKey().'" /></div>'.$form->toHtml() . "</form>  " ;
    	return $html;
    }
}
