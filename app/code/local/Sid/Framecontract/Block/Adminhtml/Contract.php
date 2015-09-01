<?php
class Sid_Framecontract_Block_Adminhtml_Contract extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contract';
    $this->_blockGroup = 'framecontract';
    $this->_headerText = Mage::helper('framecontract')->__('Framework Contract Manager');
    $this->_addButtonLabel = Mage::helper('framecontract')->__('Add Contract');
    parent::__construct();
  }
}