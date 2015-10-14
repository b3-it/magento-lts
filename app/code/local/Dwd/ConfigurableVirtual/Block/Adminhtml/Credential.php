<?php
class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_credential';
    $this->_blockGroup = 'configvirtual';
    $this->_headerText = Mage::helper('configvirtual')->__('Credentials');
    //$this->_addButtonLabel = Mage::helper('configvirtual')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}