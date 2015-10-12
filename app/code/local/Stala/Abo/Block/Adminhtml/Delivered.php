<?php
class Stala_Abo_Block_Adminhtml_Delivered extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_delivered';
    $this->_blockGroup = 'stalaabo';
    $this->_headerText = Mage::helper('stalaabo')->__('Invoice delivered Abo Items');
    parent::__construct();
    $this->removeButton('add');
    //$this->setTemplate('egovs/widget/grid/container.phtml');
    
    $this->_addButton('reload', array(
	            'label'   => Mage::helper('stalaabo')->__('Reload'),
	            'onclick' => "setLocation('{$this->getUrl('*/*/*')}')",
	            //'class'   => 'add'
	));
  }
  
 
  
 
  
  
}