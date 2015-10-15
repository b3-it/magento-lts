<?php

class Egovs_Maintenance_Block_Adminhtml_Offline extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_offline';
    $this->_blockGroup = 'maintenance';
    $this->_headerText = Mage::helper('egovs_maintenance')->__('Store Offline');
    
    parent::__construct();
    $this->removeButton('add');
  }
}