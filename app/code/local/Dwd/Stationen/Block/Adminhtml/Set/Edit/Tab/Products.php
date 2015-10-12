<?php
class Dwd_Stationen_Block_Adminhtml_Set_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_set_edit_tab_products';
    $this->_blockGroup = 'stationen';
    $this->_headerText = Mage::helper('stationen')->__('Purchased Items');
    
    parent::__construct();
    $this->removeButton('add');
  }
 
    
}