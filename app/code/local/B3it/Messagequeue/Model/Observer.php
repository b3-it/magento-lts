<?php

class B3it_Messagequeue_Model_Observer
{
    public function onCheckoutSubmitAllAfter($observer)
    {
        $order = $observer->getOrder();

        $sets = Mage::getResourceModel('b3it_mq/ruleset')->getCollection()->getModels4Categrory('order');


        foreach($sets as $set){

            $set->processEvent($order, 'checkout_submit_all_after');
        }

    }
}
