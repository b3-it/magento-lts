<?php
class Stala_Abo_Block_Adminhtml_Deliver extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_deliver';
    $this->_blockGroup = 'stalaabo';
    $this->_headerText = Mage::helper('stalaabo')->__('Deliver Subscription Contracts');
    //$this->_addButtonLabel = Mage::helper('stalaabo')->__('Add Item');
    parent::__construct();
	
    $this->_addButton('reload', array(
	            'label'   => Mage::helper('stalaabo')->__('Reload'),
	            'onclick' => "setLocation('{$this->getUrl('*/*/*')}')",
	            //'class'   => 'add'
	));
  	
  	
    
  }
  
  protected function _prepareLayout()
  {
  	parent::_prepareLayout();
  	$this->removeButton('add');
  	
	   
  	return $this;
  }
}