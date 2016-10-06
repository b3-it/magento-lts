<?php

class Sid_Framecontract_OrderController extends Mage_Core_Controller_Front_Action
{

    public function getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }
    


    /**
     * Add product to shopping cart action
     */
    public function cancelAction()
    {
    	$customer = $this->getCustomerSession()->getCustomer();
    	if(($customer == null) || ($customer->getId() == null))
    	{
    		$this->getCustomerSession()->addError($this->__('Please login first!'));
    		$this->_goBack();
    		return;
    	}
    	
    	if((!Sid_Roles_Model_Customer_Authority::getIsAuthorizedOrderer($customer)))
    	{
    		$this->getCustomerSession()->addError($this->__('You are not authorized to alter order.'));
    		$this->_goBack();
    		return;
    	}
        
    	$params = $this->getRequest()->getParams();
       	
       	try{
       	
       		$order = Mage::getModel('sales/order')->load(intval($params['order_id']));
       		if($order->getCustomerId() != $customer->getId())
       		{
       			$this->getCustomerSession()->addError($this->__('You can not cancel these order'));
       			$this->_goBack();
       			return;
       		}
       		
       		$export = Mage::getModel('exportorder/order')->load($order->getId(),'order_id');
       		if($export->getStatus() != Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)
       		{
       			$this->getCustomerSession()->addError($this->__('These order are submited'));
       			$this->_goBack();
       			return;
       		}
       		
       		$order->cancel();
       		$export->delete();
       		
       		
       		
        } catch (Mage_Core_Exception $e) {
            if ($this->getCustomerSession()->getUseNotice(true)) {
                $this->getCustomerSession()->addNotice($e->getMessage());
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError($message);
                }
            }

            $url = $this->getCustomerSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        } catch (Exception $e) {
            $this->getCustomerSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
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
