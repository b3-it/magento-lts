<?php

class Sid_Framecontract_OrderController extends Mage_Core_Controller_Front_Action
{

    public function getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }
    
    public function getSession()
    {
    	return Mage::getSingleton('core/session');
    }
    
    public function preDispatch()
    {
    	parent::preDispatch();
    	$action = $this->getRequest()->getActionName();
    	$loginUrl = Mage::helper('customer')->getLoginUrl();
    
    	if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
    		$this->setFlag('', self::FLAG_NO_DISPATCH, true);
    	}
    }

    /**
     * Add product to shopping cart action
     */
    public function cancelAction()
    {
    	$customer = $this->getCustomerSession()->getCustomer();
    	if(($customer == null) || ($customer->getId() == null))
    	{
    		$this->getSession()->addError($this->__('Please login first!'));
    		$this->_goBack();
    		return;
    	}
    	
    	if((!Sid_Roles_Model_Customer_Authority::getIsAuthorizedOrderer($customer)))
    	{
    		$this->getSession()->addError($this->__('You are not authorized to alter order.'));
    		$this->_goBack();
    		return;
    	}
        
    	$params = $this->getRequest()->getParams();
       	
       	try{
       	
       		/* @var $order Mage_Sales_Model_Order */ 
       		$order = Mage::getModel('sales/order')->load(intval($params['order_id']));
       		if($order->getCustomerId() != $customer->getId())
       		{
       			$this->getSession()->addError($this->__('You can not cancel these order'));
       			$this->_goBack();
       			return;
       		}
       		
       		$export = Mage::getModel('exportorder/order')->load($order->getId(),'order_id');
       		if(($export->getId()) && ($export->getStatus() != Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING))
       		{
       			$this->getSession()->addError($this->__('These order are submited'));
       			$this->_goBack();
       			return;
       		}
       		
       		$service = Mage::getModel('sales/service_order', $order);
       		foreach($order->getInvoiceCollection() as $invoice)
       		{
       			if($invoice->getStatus() == Mage_Sales_Model_Order_Invoice::STATE_OPEN )
       			{
		       		$creditmemo = $service->prepareInvoiceCreditmemo($invoice);
		       		$creditmemo->setRefundRequested(true);
		       		$creditmemo->setOfflineRequested(true);
		       		$creditmemo->register();
		       		$transactionSave = Mage::getModel('core/resource_transaction')
		       		->addObject($creditmemo)
		       		->addObject($creditmemo->getOrder());
		       		if ($creditmemo->getInvoice()) {
		       			$transactionSave->addObject($creditmemo->getInvoice());
		       		}
		       		$transactionSave->save();
       			}
       		}
       		
       		
       		if($order->canCancel())
       		{
       			$order->cancel()->save();
       			$export->delete();
       		}
       		$this->_goBack();
       		
       		
        } catch (Mage_Core_Exception $e) {
            if ($this->getSession()->getUseNotice(true)) {
                $this->getSession()->addNotice($e->getMessage());
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->getSession()->addError($message);
                }
            }

            $url = $this->getCustomerSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        } catch (Exception $e) {
            $this->getSession()->addException($e, $this->__('Cannot cancel the order.'));
            Mage::logException($e);
            $this->_goBack();
        }
    }


    protected function _goBack()
    {
    	
    	$this->_redirect('sales/order/history');
    	
    	return $this;
    }
    
}
