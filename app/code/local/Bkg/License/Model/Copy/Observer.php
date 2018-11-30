<?php

/**
 * BBkg_License_Model_Copy_Observer
 *
 * @category    Bkg
 * @package     Bkg_License
 * @name        Bkg_License_Model_Copy_Observer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy_Observer
{

    public function onSubscriptionCalculate($observer) {
        $orderItem = $observer->getOrderItem();
        $subscription = $observer->getSubscription();


        $firstOrderItem = null;
       if($subscription->getFirstOrderitemId()){
           $firstOrderItem = Mage::getModel('sales/order_item')->load($subscription->getFirstOrderitemId());
       }

        if((!$firstOrderItem) ||(!$firstOrderItem->getLicenseId())){
            return;
        }

        //Lizenz aus dem ersten OrderItem laden und ggf die Periode des Abo's überschreiben
        $license = Mage::getModel('bkg_license/copy')->load($firstOrderItem->getLicenseId());
        if($license->getPeriodId()){
            $period = $license->getPeriod();
            $period->unsetData('id');
            $subscription->getPeriod()->setData($period->getData());
        }
        if($firstOrderItem){
            unset($firstOrderItem);
        }

        if($period){
            unset($period);
        }
        if($license)
        {
            unset($license);
        }

    }
    
}
