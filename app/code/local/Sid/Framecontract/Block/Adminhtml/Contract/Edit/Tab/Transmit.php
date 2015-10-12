<?php
class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Transmit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contract_edit_tab_transmit';
    $this->_blockGroup = 'framecontract';
    $this->_headerText = Mage::helper('framecontract')->__('Message History');
    $this->_addButtonLabel = Mage::helper('framecontract')->__('Add Item');
    parent::__construct();
    $this->removeButton('add');
  }
}