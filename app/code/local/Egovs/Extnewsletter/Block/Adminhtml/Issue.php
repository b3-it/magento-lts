<?php
class Egovs_Extnewsletter_Block_Adminhtml_Issue extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_issue';
    $this->_blockGroup = 'extnewsletter';
    $this->_headerText = Mage::helper('extnewsletter')->__('Issue Manager');
    $this->_addButtonLabel = Mage::helper('extnewsletter')->__('Add Issue');
    parent::__construct();
   
  }
}