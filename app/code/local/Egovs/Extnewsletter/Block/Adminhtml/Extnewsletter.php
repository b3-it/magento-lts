<?php
class Egovs_Extnewsletter_Block_Adminhtml_Extnewsletter extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_extnewsletter';
    $this->_blockGroup = 'extnewsletter';
    $this->_headerText = Mage::helper('extnewsletter')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('extnewsletter')->__('Add Item');
    parent::__construct();
  }
}