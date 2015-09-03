<?php
class Dwd_Sales_Block_Adminhtml_Shipping extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_shipping';
    $this->_blockGroup = 'dwdsales';
    $this->_headerText = Mage::helper('sales')->__('Shipping Items');
    parent::__construct();
    $this->_removeButton('add');
  }
}