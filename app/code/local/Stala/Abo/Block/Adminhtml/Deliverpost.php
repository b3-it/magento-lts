<?php
class Stala_Abo_Block_Adminhtml_Deliverpost extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_deliverpost';
    $this->_blockGroup = 'stalaabo';
    $this->_headerText = Mage::helper('stalaabo')->__('Deliver Subscription Contracts');
    //$this->_addButtonLabel = Mage::helper('stalaabo')->__('Add Item');
    parent::__construct();

    $deliverIds = $this->getRequest()->getParam('abo_deliver_id');
	
    if($deliverIds)
    {
	   	$deliverIds = implode(',',$deliverIds);
	    
	  	$this->_addButton('label', array(
	            'label'     => Mage::helper('stalaabo')->__('Print Label'),
	            'onclick'   => 'setLocation(\'' .$this->getUrl('*/stalaabo_deliverpost/createLabel',array('deliver_id'=>$deliverIds)) .'\')',
	            'class'     => 'button',
	        ));
	  	
	    $this->_addButton('shipping', array(
	            'label'     => Mage::helper('stalaabo')->__('Print Deliverynote'),
	            'onclick'   => 'setLocation(\'' .$this->getUrl('*/stalaabo_deliverpost/createShipping',array('deliver_id'=>$deliverIds)).'\')',
	            'class'     => 'button',
	        ));
	        
	   $this->_addButton('finish', array(
	            'label'     => Mage::helper('stalaabo')->__('Finish Shipping'),
	            'onclick'   => 'setLocation(\'' . $this->getUrl('*/stalaabo_deliverpost/finishShipping',array('deliver_id'=>$deliverIds)) .'\')',
	            'class'     => 'button',
	        ));
    }
    
  }
  
  protected function _prepareLayout()
  {
  	parent::_prepareLayout();
  	$this->removeButton('add');
 
	   
  	return $this;
  }
  

}