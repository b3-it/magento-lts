<?php
class Egovs_Informationservice_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_report';
    $this->_blockGroup = 'informationservice';
    $this->_headerText = Mage::helper('informationservice')->__('Information Service');
    
    parent::__construct();
  }
  
  public function _prepareLayout()
  {
  		$this->removeButton('add');
  		parent::_prepareLayout();
  		return $this;
  }
}