<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Model_Notification_Order
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Model_Notification_AgreementObserver extends Mage_Core_Model_Abstract
{
    /**
     * @param Varien_Event_Observer $observer
     * @return Varien_Event_Observer
     * @throws Exception
     */
    public function OnCheckoutSubmitAllAfter(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = $observer->getQuote();

        /** string|int $storeId */
        $storeId = $quote->getStore()->getId();

        /** @var Bfr_Eventparticipants_Model_Notification_Order $notification */
        $notification = Mage::getModel('bfr_eventparticipants/notification_order');

        /** @var Mage_Sales_Model_Quote_Item $item */
        foreach($quote->getAllVisibleItems() as $item){
            if($item->getProductType() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE && $item->getBuyRequest()->getData('eventparticipants') === 'on'){
                $hash = bin2hex(random_bytes(20));
                $notification->unsetData();
                $notification->setEventId($item->getProductId());
                $notification->setSignedAt(date('YYYY-MM-DD hh:mm:ss', time()));
                $notification->setHash($hash);
                $notification->setOrderItemId($item->getId());
                $notification->setStatus(0);
                $notification->setCustomerId($item->getQuote()->getCustomerId());
                $notification->setQuoteItemId($item->getQuoteId());
                $notification->save();

                Mage::helper('bfr_eventparticipants')->sendEmail('eventparticipants/participation_agreement_email/template', $storeId, $item, $hash);
            }
        }
        return $observer;
    }
}
