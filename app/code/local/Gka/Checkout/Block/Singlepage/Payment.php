<?php

class Gka_Checkout_Block_Singlepage_Payment extends Mage_Payment_Block_Form_Container
{
 

    /**
     * Check and prepare payment method model
     *
     * @return bool
     */
    protected function _canUseMethod($method)
    {
        
        return parent::_canUseMethod($method);
    }
    
    public function getMethods() {
    	parent::getMethods();
    	
    	$methods = $this->getData('methods');
    	if (count($methods) == 1
    		&& (current($methods)->getCode() == 'freepayment' || current($methods)->getCode() == 'free')
    	) {
    		/* @var $action Egovs_Checkout_MultipageController */
    		$action = $this->getAction();
    		$action->getRequest()->setPost('payment', array('method' =>current($methods)->getCode()));
    		$action->getRequest()->setPost('form_key', Mage::getSingleton('core/session')->getFormKey());
    		
    		$action->billingPostAction();
    	}
    	return $methods;
    }

    /**
     * Retrieve code of current payment method
     *
     * @return mixed
     */
    public function getSelectedMethodCode()
    {
        if ($method = $this->getQuote()->getPayment()->getMethod()) {
            return $method;
        }
        return false;
    }

  

    /**
     * Retrieve quote model object
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    /**
     * Retrieve url for select billing address
     *
     * @return string
     */
    public function getSelectAddressUrl()
    {
        return $this->getUrl('*/edit/selectBilling', array('_secure'=>true));
    }


    public function getPaymentAdditionalFormUrl()
    {
    	return $this->getUrl('*/singlepage/paymentAdditionalForm', array('_secure'=>true));
    }
    
}