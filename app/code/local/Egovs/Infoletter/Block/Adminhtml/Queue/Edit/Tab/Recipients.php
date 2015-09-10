<?php
class Egovs_Infoletter_Block_Adminhtml_Queue_Edit_Tab_Recipients extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_queue_edit_tab_recipients';
    $this->_blockGroup = 'infoletter';
    $this->_headerText = Mage::helper('infoletter')->__('Recipients');
    //$this->_addButtonLabel = Mage::helper('stationen')->__('Link Stations into Set');
    
    parent::__construct();
    $this->_removeButton('add');
  }
  
 	public function xgetCreateUrl()
    {
    	$model = Mage::registry('stationen_data');
        return $this->getUrl('*/stationen_derivation/new',array('parent_id'=> $model->getId()));
    }
    
	
    
 
    
}