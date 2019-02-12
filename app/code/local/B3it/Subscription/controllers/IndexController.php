<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_IndexController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_IndexController extends Mage_Core_Controller_Front_Action
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
    	$subscription_id = intval($this->getRequest()->getParam('id'));
    	
    	$subscription = $this->_getSubscription($subscription_id);
    	
    	if(!$subscription){
    		Mage::getSingleton('core/session')->addError($this->__('Internal Error'));
    		$this->_redirect('customer/account');
    		return;
    	}
    	
    	$this->_cancelSubscription($subscription);
    	
    	$this->_redirect('b3it_subscription/index/view');
    }
    
   
    protected function _cancelSubscription($subscription)
    {
    	/* @var B3it_Subscription_*/
    	if ($subscription == null){
    		return;
    	}
    	
    	$data=array();
    	
    	$orderitem = Mage::getModel('sales/order_item')->load($subscription->getCurrentOrderitemId());
    	$data['item'] = $subscription;
    	$data['order'] = Mage::getModel('sales/order')->load($subscription->getFirstOrderId());
    	$data['product'] = Mage::getModel('catalog/product')->load($orderitem->getProductId());
    	$data['station'] = Mage::getModel('stationen/stationen')->load($orderitem->getStationId());
    	//$customer = Mage::getModel('customer/customer')->load($subscription->getCustomerId());
    	
    	
    	if($subscription->getTierPriceDependProviderCount() > 0)
    	{
    		$customer = Mage::getSingleton('customer/session')->getCustomer();
    		Mage::helper('b3it_subscription')->sendEmail($data['product']->getBearbeiterEmail(), $customer, $data, 'b3it_subscription/email/cancel_subscription_denied_template');
    		Mage::getSingleton('core/session')->addError($this->__('Your subscription can not be deleted at the moment because of tier price usage. The operator has been informed and will contact you!'));
    		$this->_redirect('b3it_subscription/index/view');
    		return;	

    	}
    	else
    	{
    		$subscription->setStatus(B3it_Subscription_Model_Status::STATUS_CANCELED)->save();
    		$customer = Mage::getSingleton('customer/session')->getCustomer();
    		Mage::helper('b3it_subscription')->sendEmail($customer->getEmail(), $customer, $data, 'b3it_subscription/email/cancel_subscription_template');
    	}
    }
    
    
    protected function _getSubscription($itemId)
    {
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
  	
    	$collection = Mage::getModel('b3it_subscription/subscription')->getCollection();
    	
    	$collection->getSelect()
    		->join('sales_flat_order','sales_flat_order.entity_id = main_table.current_order_id',array())
    		->where('customer_id='.$customer->getId())
    		->where('main_table.subscription_id='.$itemId)
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