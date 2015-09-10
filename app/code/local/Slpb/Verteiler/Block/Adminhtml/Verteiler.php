<?php
class Slpb_Verteiler_Block_Adminhtml_Verteiler extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_verteiler';
    $this->_blockGroup = 'verteiler';
    $this->_headerText = Mage::helper('verteiler')->__('Verteiler');
    $this->_addButtonLabel = Mage::helper('verteiler')->__('Neuer Verteiler');
    parent::__construct();
  }
}