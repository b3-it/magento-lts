<?php
class Dwd_Stationen_Block_Adminhtml_Set extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_set';
    $this->_blockGroup = 'stationen';
    $this->_headerText = Mage::helper('stationen')->__('Set Manager');
    $this->_addButtonLabel = Mage::helper('stationen')->__('Add Set');
    
   
    parent::__construct();
  }
  
 
}