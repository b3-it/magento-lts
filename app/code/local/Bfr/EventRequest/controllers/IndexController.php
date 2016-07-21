<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_IndexController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_IndexController extends Mage_Checkout_Controller_Action
{
    public function indexAction()
    {
        parent::preDispatch();
        $this->_preDispatchValidateCustomer();

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if (!$customer || !$customer->getId()) {
            Mage::getSingleton('checkout/session')->addError( $this->__("Please Login first!") );
            $this->_redirect('checkout/cart');
            return $this;
        }

        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $register = Mage::getModel('eventrequest/request');
        $errors = $register->registerQuote($quote, $customer);

        if(count($errors) > 0){
            foreach($errors as $error){
                Mage::getSingleton('checkout/session')->addError($error);
            }
            $this->_redirect('checkout/cart');
            return $this;
        }

        Mage::getSingleton('checkout/session')->addSuccess( $this->__("Your event request has been registered!") );
        $this->_redirect('checkout/cart');
    }
}