<?php
class Slpb_Extstock_Block_Adminhtml_Stockorder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stockorder';
    $this->_blockGroup = 'extstock';
    $this->_headerText = Mage::helper('extstock')->__('Bestellscheine');

    parent::__construct();
    $this->_removeButton('add');
  }
}