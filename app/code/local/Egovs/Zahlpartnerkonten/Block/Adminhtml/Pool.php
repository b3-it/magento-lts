<?php
class Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_pool';
    $this->_blockGroup = 'zpkonten';
    $this->_headerText = Mage::helper('zpkonten')->__('Zahlpartnerkonten Manager');
    $this->_addButtonLabel = Mage::helper('zpkonten')->__('Kassenzeichen erzeugen');
    parent::__construct();
  }
}