<?php

/**
 * Multipage checkout controller
 *
 * 
 */
class Slpb_Checkout_Controller_Abstract extends Mage_Checkout_Controller_Action
{
    
    protected $_checkout = null;
    protected $_storeid = null;
    
    /**
     * Retrieve checkout model
     *
     * @return Slpb_Checkout_Controller_Abstract
     */
    protected function _getCheckout()
    {
    	if($this->_checkout == null)
    	{
        	$this->_checkout = Mage::getSingleton('slpbcheckout/shop');
    	}
    	
    	return $this->_checkout;
    }

    
    protected function getStoreId()
    {
    	if($this->_storeid == null)
    	{
    		$this->_storeid = $this->_getCheckout()->getStoreId();
    	}
    	
    	return $this->_storeid;
    }
    
 
    /**
     * Retrieve checkout url heler
     *
     * @return Slpb_Checkout_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('slpbcheckout/url');
    }

	public function preDispatch()
    {
    	
        parent::preDispatch();
        
        $action = $this->getRequest()->getActionName();
        if ($action == 'successview')
        {
        	if($this->_getCheckout()->getCheckoutSession()->getDisplaySuccess()== true) 
        	{
             	$this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(false);
     			return $this;
        	}else {
        		$this->setFlag('', self::FLAG_NO_DISPATCH, true);
            	$this->_redirect('checkout/cart');
            	return;
        	}
        }
        
              //warenkorb begrenzung
        try
        {
        	$quote = $this->_getCheckout()->getQuote();
        
        	Mage::dispatchEvent('checkout_entry_before', array('quote'=>$quote));
        }
    	catch (Mage_Core_Exception $e) {
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            $this->_redirect('checkout/cart');
            return;
        }
        catch(Exception $ex)
        {
        	Mage::getSingleton('checkout/session')->addException(
                $ex,
                $ex->getMessage()
            );
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            $this->_redirect('checkout/cart');
            return;
        }   
    }
    /**
     * Index action of multipage checkout
     */
    public function indexAction()
    {
       
        $this->_redirect('slpb_checkout/multipage/addresses',array('_secure'=>true));
        
    }

      /**
     * multipage checkout new address page
     */
    public function addressesAction()
    {
        
   
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }
    
    
    protected function redirectSuccess()
    {
    	$this->_redirect('slpb_checkout/shop/successview',array('_secure'=>true));
    }

    /**
     * multipage checkout process posted addresses
     */
    public function addressesPostAction()
    {
    	
    	
    	try
    	{
	        if ($this->getRequest()->isPost()) {
	        	
	            $data = $this->getRequest()->getPost('billing', array());	            
	            Mage::getSingleton('customer/session')->setData('addresspostdata',$data);

	            	
	            if(isset($data) && isset($data['country_id']))
	            {
	            	if($data['country_id'] != 'DE') unset($data['region']);
	            }
	            
	            $result = $this->_getCheckout()->saveAddress($data);
	            if($result !== true)
	            {
	            	Mage::getSingleton('checkout/session')->addError($result);
	            	$this->_redirect('*/*/addresses',array('_secure'=>true));
	            	return;
	            }
	            
	            Mage::getSingleton('customer/session')->unsetData('addresspostdata');

	            $this->_getCheckout()->getCheckoutSession()->clear();
            	$this->_getCheckout()->getCheckoutSession()->setDisplaySuccess(true);
	            
	            Mage::getSingleton('checkout/session')->addSuccess(Mage::helper('slpbcheckout')->__('Thank you for your purchase!'));
 				$this->redirectSuccess();
 		   }
    	}
       	catch (Mage_Core_Exception $e) {
       		Mage::log("mpcheckout::".$e->getMessage(), Zend_Log::ERR, Slpb_Helper::EXCEPTION_LOG_FILE);
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
            //$this->_redirect('*/*/addresses',array('_secure'=>true));
            $this->_redirect('checkout/cart');
        }
        catch (Exception $e) {
        	Mage::getSingleton('checkout/session')->addError($e->getMessage());
            Mage::getSingleton('checkout/session')->addException(
                $e,
                Mage::helper('checkout')->__('Data saving problem'));
            Mage::log("mpcheckout::".$e->getMessage(), Zend_Log::NOTICE, Slpb_Helper::LOG_FILE);
            
            $this->_redirect('*/*/addresses',array('_secure'=>true));
        }
        
       
   }
   
   public function successviewAction()
   {
   	  
        
        $lastQuoteId = $this->_getCheckout()->getCheckout()->getLastQuoteId();
        $lastOrderId = $this->_getCheckout()->getCheckout()->getLastOrderId();
        
        $msg = "successviewAction [lastQuoteId: $lastQuoteId; lastOrderId: $lastOrderId;].";				
        Mage::log("mpcheckout::".$msg, Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			
    	if (!$lastQuoteId || !$lastOrderId) {
            $this->_redirect('checkout/cart');
            return;
        }
		
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        Mage::dispatchEvent('checkout_onepage_controller_success_action');
        $this->renderLayout();
     
   }
    

    
}
