<?php
class Dwd_Stationen_Block_Adminhtml_Stationen_Edit_Tab_Derivation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stationen_edit_tab_derivation';
    $this->_blockGroup = 'stationen';
    $this->_headerText = Mage::helper('stationen')->__('Manage Derivations');
    $this->_addButtonLabel = Mage::helper('stationen')->__('Add Derivation');
    parent::__construct();
  }
  
 	public function getCreateUrl()
    {
    	$model = Mage::registry('stationen_data');
        return $this->getUrl('*/stationen_derivation/new',array('parent_id'=> $model->getId()));
    }
    
	
    
 
    
}