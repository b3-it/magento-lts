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
        /** @var Mage_Sales_Model_Order $order */
        $order = $observer->getOrder();

        /** string|int $storeId */
        $storeId = $order->getStore()->getId();

        /** @var Bfr_Eventparticipants_Model_Notification_Order $notification */
        $notification = Mage::getModel('bfr_eventparticipants/notification_order');

        /** @var Mage_Sales_Model_Quote_Item $item */
        foreach($order->getAllVisibleItems() as $item){
            if($item->getProductType() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE && $item->getBuyRequest()->getData('eventparticipants') === 'on'){
                $hash = bin2hex(random_bytes(20));

                if($eventId = $this->_getEventId($item->getProductId())){
                    $notification->unsetData();
                    $notification->setEventId($eventId);
                    $notification->setSignedAt(date('Y-m-d h:m:s'));
                    $notification->setHash($hash);
                    $notification->setOrderItemId($item->getId());
                    $notification->setStatus(1);
                    $notification->setCustomerId($order->getCustomerId());
                    $notification->save();

                    Mage::helper('bfr_eventparticipants')->sendEmail('eventmanager/participation_agreement_email/template', $storeId, $order, $hash, $item->getName());
                }
            }
        }
        return $observer;
    }


    /**
     * @param Varien_Event_Observer $observer
     * @return Varien_Event_Observer
     */
    public function OnEventManagerExportGridPrepareCollection(Varien_Event_Observer $observer)
    {
        /** @var Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Export $grid */
        $grid = $observer->getData('grid');
        if($grid == null){
            return $observer;
        }

        /** @var Bfr_EventManager_Model_Resource_Participant_Collection $collection */
        $collection = $grid->getCollection();
        $sql = new Zend_Db_Expr('');
        $collection->getSelect()->joinLeft(['notification_order' => $collection->getTable('bfr_eventparticipants/notification_order')], 'notification_order.order_item_id = main_table.order_item_id', ['agreement_status' => 'coalesce(notification_order.status, 0)']);
        return $observer;
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return Varien_Event_Observer
     * @throws Exception
     */
    public function OnEventManagerExportGridPrepareColumns(Varien_Event_Observer $observer)
    {
        /** @var Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Export $grid */
        $grid = $observer->getData('grid');
        if($grid == null){
            return $observer;
        }

        $grid->addColumn('notification_order_status', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Status'),
            'align' => 'left',
            'index' => 'agreement_status',
            'filter_index' => 'notification_order.status',
            'type'  => 'options',
            'options' => Bfr_Eventparticipants_Model_Resource_Export::getOptionArray(),
        ));
        return $observer;
    }

    /**
     * @param $productId
     * @return bool|mixed
     */
    protected function _getEventId($productId)
    {
        $model = Mage::getModel('eventmanager/event')->load($productId, "product_id");
        if(!$model->getId()){
            Mage::log('event not found:' . $productId);
            return false;
        }
        return $model->getId();
    }
}
