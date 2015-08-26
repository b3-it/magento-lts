<?php
class Dwd_Stationen_Block_Adminhtml_Set_Edit_Tab_Stationen extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_set_edit_tab_stationen';
    $this->_blockGroup = 'stationen';
    $this->_headerText = Mage::helper('stationen')->__('Stations');
    
    parent::__construct();
    $this->removeButton('add');
  }
 
    
}