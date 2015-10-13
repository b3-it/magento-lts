<?php
class Egovs_Informationservice_Block_Adminhtml_Requesttype extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_requesttype';
    $this->_blockGroup = 'informationservice';
    $this->_headerText = Mage::helper('informationservice')->__('Request Type');
    $this->_addButtonLabel = Mage::helper('informationservice')->__('Add Request Type');
    parent::__construct();
  }
}