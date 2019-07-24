<?php

class Egovs_Base_Model_Owner_Observer 
{
    public function onSalesOrderPlaceBeforeAdmin($observer)
    {
        $order = $observer->getOrder();
        if($order)
        {
            $owner = Mage::getSingleton('admin/session')->getUser();
            if($owner)
            {
                $order->setOwner($owner->getName());
                $order->setOwnerPhone($owner->getPhone());
            }
        }
    }

    public function onSalesOrderPlaceBefore($observer)
    {
        $order = $observer->getOrder();
        if($order)
        {
            $order->setOwner(Mage::getStoreConfig('sales/identity/owner_name'));
            $order->setOwnerPhone(Mage::getStoreConfig('sales/identity/owner_phone')); 
        }
    }
}

?>