<?php
class Dwd_Stationen_Block_Adminhtml_Stationen extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stationen';
    $this->_blockGroup = 'stationen';
    $this->_headerText = Mage::helper('stationen')->__('Stations Manager');
    $this->_addButtonLabel = Mage::helper('stationen')->__('Add Station');
    parent::__construct();
  }
}