<?php
class Bkg_VirtualAccess_Block_Adminhtml_Purchased extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_purchased';
    $this->_blockGroup = 'virtualaccess';
    $this->_headerText = Mage::helper('virtualaccess')->__('Credentials');
    //$this->_addButtonLabel = Mage::helper('virtualaccess')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}