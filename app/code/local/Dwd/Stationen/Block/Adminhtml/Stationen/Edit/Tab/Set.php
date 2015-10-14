<?php
class Dwd_Stationen_Block_Adminhtml_Stationen_Edit_Tab_Set extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stationen_edit_tab_set';
    $this->_blockGroup = 'stationen';
    $this->_headerText = Mage::helper('stationen')->__('Link Stations into Set');
    //$this->_addButtonLabel = Mage::helper('stationen')->__('Link Stations into Set');
    
    parent::__construct();
    $this->_removeButton('add');
  }
  
 	public function getCreateUrl()
    {
    	$model = Mage::registry('stationen_data');
        return $this->getUrl('*/stationen_derivation/new',array('parent_id'=> $model->getId()));
    }
    
	
    
 
    
}