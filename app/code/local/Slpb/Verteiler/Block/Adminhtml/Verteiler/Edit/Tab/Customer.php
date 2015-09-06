<?php
class Slpb_Verteiler_Block_Adminhtml_Verteiler_Edit_Tab_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_verteiler';
    $this->_blockGroup = 'verteiler';
    $this->_headerText = Mage::helper('verteiler')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('verteiler')->__('Add Item');
    parent::__construct();
  }
}