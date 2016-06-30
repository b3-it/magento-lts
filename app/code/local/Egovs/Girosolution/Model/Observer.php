<?php

/**
 * Girosolution
 *
 * Überschreibt hier nur Egovs_Paymentbase_Helper_Data
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @name       	Egovs_Girosolution_Helper_Data
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Girosolution_Model_Observer
{ 
    public function paymentMethodIsActive(Varien_Event_Observer $observer) {
        $event           = $observer->getEvent();
        $method          = $event->getMethodInstance();
        $result          = $event->getResult();
        $currencyCode    = Mage::app()->getStore()->getCurrentCurrencyCode();
       
         
        if( $currencyCode != 'EUR'){
            if ($method->getCode() == 'egovs_girosolution_creditcard' ){
                $result->isAvailable = true;
            } else if($method->getCode() == 'egovs_girosolution_giropay' ){
                $result->isAvailable = false;
            }
        }
    }
 
}