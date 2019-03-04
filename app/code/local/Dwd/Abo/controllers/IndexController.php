<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_IndexController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    
    public function viewAction()
    {
    	$this->loadLayout();
    	//$this->getLayout()->getBlock('head')->setTitle($this->__('My Data Access'));
		$this->renderLayout();
    }
    
    public function cancelAction()
    {
    	$abo_id = intval($this->getRequest()->getParam('id'));
    	
    	$abo = $this->_getAbo($abo_id);
    	
    	if(!$abo){
    		Mage::getSingleton('core/session')->addError($this->__('Internal Error'));
    		$this->_redirect('customer/account');
    		return;
    	}
    	
    	$this->_cancelAbo($abo);
    	
    	$this->_redirect('dwd_abo/index/view');
    }
    
   
    protected function _cancelAbo($abo)
    {
    	/* @var Dwd_Abo_*/
    	if ($abo == null){
    		return;
    	}
    	
    	$data=array();
    	
    	$orderitem = Mage::getModel('sales/order_item')->load($abo->getCurrentOrderitemId());
    	$data['item'] = $abo;
    	$data['order'] = Mage::getModel('sales/order')->load($abo->getFirstOrderId());
    	$data['product'] = Mage::getModel('catalog/product')->load($orderitem->getProductId());
    	$data['station'] = Mage::getModel('stationen/stationen')->load($orderitem->getStationId());
    	//$customer = Mage::getModel('customer/customer')->load($abo->getCustomerId());
    	
    	
    	if($abo->getTierPriceDependProviderCount() > 0)
    	{
    		$customer = Mage::getSingleton('customer/session')->getCustomer();
    		Mage::helper('dwd_abo')->sendEmail($data['product']->getBearbeiterEmail(), $customer, $data, 'dwd_abo/email/cancel_abo_denied_template');
    		Mage::getSingleton('core/session')->addError($this->__('Your subscription can not be deleted at the moment because of tier price usage. The operator has been informed and will contact you!'));
    		$this->_redirect('dwd_abo/index/view');
    		return;	

    	}
    	else
    	{
    		$abo->setStatus(Dwd_Abo_Model_Status::STATUS_CANCELED)->save();
    		$customer = Mage::getSingleton('customer/session')->getCustomer();
    		Mage::helper('dwd_abo')->sendEmail($customer->getEmail(), $customer, $data, 'dwd_abo/email/cancel_abo_template');
    	}
    }
    
    
    protected function _getAbo($itemId)
    {
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
  	
    	$collection = Mage::getModel('dwd_abo/abo')->getCollection();
    	
    	$collection->getSelect()
    		->join('sales_flat_order','sales_flat_order.entity_id = main_table.current_order_id',array())
    		->where('customer_id='.$customer->getId())
    		->where('main_table.abo_id='.$itemId)
    		->where("cancelation_period_end >= '" . Mage::getModel('core/date')->gmtDate()."'")
    	;
    	   	
    	
    	//die($collection->getSelect()->__toString());
    	$items = $collection->getItems();
		if (count($items) > 0) {
			return array_shift($items);
		} 	
		
		Mage::log('ABO Item could not loaded. CustomerId:' . $customer->getId() . '; Item: '. $itemId);
		
		return null;	
		
    }
    
    public function preDispatch() {
    	parent::preDispatch();
    
    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }
    
  
}