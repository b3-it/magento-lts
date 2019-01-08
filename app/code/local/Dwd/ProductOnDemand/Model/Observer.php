<?php
/**
 * Product On Demand Observer
 *
 * @category    Dwd
 * @package     Dwd_ProductOnDemand
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 */
class Dwd_ProductOnDemand_Model_Observer extends Varien_Object
{
    const XML_PATH_DISABLE_GUEST_CHECKOUT   = 'catalog/downloadable/disable_guest_checkout';

    /**
     * Set checkout session flag if order has downloadable product(s)
     *
     * @param Varien_Object $observer Observer
     * 
     * @return Dwd_ProductOnDemand_Model_Observer
     */
    public function setHasDownloadableProducts($observer)
    {
        $session = Mage::getSingleton('checkout/session');
        if (!$session->getHasDownloadableProducts()) {
            $order = $observer->getEvent()->getOrder();
            foreach ($order->getAllItems() as $item) {
                /* @var $item Mage_Sales_Model_Order_Item */
                if ($item->getProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                	|| $item->getRealProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
               		|| $item->getProductOptionByCode('is_downloadable')
                ) {
                    $session->setHasDownloadableProducts(true);
                    break;
                }
            }
        }
        return $this;
    }

    /**
     * Set status of link
     *
     * @param Varien_Object $observer Observer
     * 
     * @return Dwd_ProductOnDemand_Model_Observer
     */
    public function setLinkStatus($observer)
    {
        $order = $observer->getEvent()->getOrder();

        if (!$order->getId()) {
            //order not saved in the database
            return $this;
        }

        /* @var $order Mage_Sales_Model_Order */
        $status = '';
        $linkStatuses = array(
            'pending'         => Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING,
            'expired'         => Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED,
            'avail'           => Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_AVAILABLE,
            'payment_pending' => Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING_PAYMENT,
            'payment_review'  => Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PAYMENT_REVIEW
        );

        $downloadableItemsStatuses = array();
        $orderItemStatusToEnable = Mage::getStoreConfig(
            Mage_Downloadable_Model_Link_Purchased_Item::XML_PATH_ORDER_ITEM_STATUS, $order->getStoreId()
        );
        $linksToDelete = array(array());

        if ($order->getState() == Mage_Sales_Model_Order::STATE_HOLDED) {
            $status = $linkStatuses['pending'];
        } elseif ($order->isCanceled()
                  || $order->getState() == Mage_Sales_Model_Order::STATE_CLOSED
                  || $order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE
        ) {
            $expiredStatuses = array(
                Mage_Sales_Model_Order_Item::STATUS_CANCELED,
                Mage_Sales_Model_Order_Item::STATUS_REFUNDED,
            );
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                    || $item->getRealProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                ) {
                    if (in_array($item->getStatusId(), $expiredStatuses)) {
                        $downloadableItemsStatuses[$item->getId()] = $linkStatuses['expired'];
                    } else {
                        $downloadableItemsStatuses[$item->getId()] = $linkStatuses['avail'];
                        $linksToDelete[] = $item->getProductOptionByCode('links');
                    }
                }
            }
        } elseif ($order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT) {
            $status = $linkStatuses['payment_pending'];
        } elseif ($order->getState() == Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW) {
            $status = $linkStatuses['payment_review'];
        } else {
            $availableStatuses = array($orderItemStatusToEnable, Mage_Sales_Model_Order_Item::STATUS_INVOICED);
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                    || $item->getRealProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                ) {
                    if (in_array($item->getStatusId(), $availableStatuses)) {
                        $downloadableItemsStatuses[$item->getId()] = $linkStatuses['avail'];
                        $linksToDelete[] = $item->getProductOptionByCode('links');
                    }
                }
            }
        }
        $linksToDelete = call_user_func_array('array_merge', $linksToDelete);

        if (!$downloadableItemsStatuses && $status) {
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                    || $item->getRealProductType() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
                ) {
                    $downloadableItemsStatuses[$item->getId()] = $status;
                }
            }
        }

        if ($downloadableItemsStatuses) {
            $linkPurchased = Mage::getResourceModel('downloadable/link_purchased_item_collection')
            	->addFieldToFilter('order_item_id', array('in' => array_keys($downloadableItemsStatuses)));
            foreach ($linkPurchased as $link) {
                if ($link->getStatus() != $linkStatuses['expired']
                    && !empty($downloadableItemsStatuses[$link->getOrderItemId()])
                ) {
                    $link->setStatus($downloadableItemsStatuses[$link->getOrderItemId()])
                    ->save();
                }
            }
        }
        
        if (count($linksToDelete) > 0) {
        	Mage::getResourceModel('downloadable/link')->deleteItems($linksToDelete);
        }
        return $this;
    }

    /**
     * Check is allowed guest checkuot if quote contain downloadable product(s)
     *
     * @param Varien_Event_Observer $observer Observer
     * @return Mage_Downloadable_Model_Observer
     */
    public function isAllowedGuestCheckout(Varien_Event_Observer $observer)
    {
        $quote  = $observer->getEvent()->getQuote();
        /* @var $quote Mage_Sales_Model_Quote */
        $store  = $observer->getEvent()->getStore();
        $result = $observer->getEvent()->getResult();

        $isContain = false;

        foreach ($quote->getAllItems() as $item) {
            if (($product = $item->getProduct())
            	&& $product->getTypeId() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
            ) {
                $isContain = true;
            }
        }

        if ($isContain && Mage::getStoreConfigFlag(self::XML_PATH_DISABLE_GUEST_CHECKOUT, $store)) {
            $result->setIsAllowed(false);
        }

        return $this;
    }
    
    /**
     * Validiert ob das valid_to Feld des Links noch gültig ist.
     *
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     *
     * @return Dwd_ProductOnDemand_Model_Observer
     */
    public function cleanUpExpiredPurchasedLinks($schedule) {
		Mage::dispatchEvent('dwd_pod_clear_expired_purchased_links_before', array('dwd_pod_observer' => $this));
		
		Mage::helper('prondemand')->cleanUpExpiredPurchasedLinks($this);
		
		return $this;
	}
}
