<?php
class Egovs_Informationservice_Block_Adminhtml_Request extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_request';
    $this->_blockGroup = 'informationservice';
    $this->_headerText = Mage::helper('informationservice')->__('Information Service');
    $this->_addButtonLabel = Mage::helper('informationservice')->__('New Request');
    
 
    
    parent::__construct();
  }
  
  
  public function _prepareLayout()
  {
  	//falls von der Kundenverwaltung
    $customer_id = $this->getRequest()->getParam('customer_id');
    if($customer_id != null)
    {
      	 $customer_id = intval($customer_id);
      	$this->_updateButton('add', 'onclick', "setLocation('". $this->getUrl('informationservice/adminhtml_request/edit', array('customer' => $customer_id))."');");
    }
    return parent::_prepareLayout();
  }

}