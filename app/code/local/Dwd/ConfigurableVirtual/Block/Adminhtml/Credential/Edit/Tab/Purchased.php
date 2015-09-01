<?php
class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential_Edit_Tab_Purchased extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_credential_edit_tab_purchased';
    $this->_blockGroup = 'configvirtual';
    $this->_headerText = Mage::helper('configvirtual')->__('Purchased Items');
    
    parent::__construct();
    $this->removeButton('add');
  }
 
    
}