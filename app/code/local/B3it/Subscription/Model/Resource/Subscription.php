<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Mysql4_Subscription
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Mysql4_Subscription extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the subscription_subscription_id refers to the key field in your database table.
        $this->_init('b3it_subscription/subscription', 'subscription_id');
    }
    
    
    public function removeTierPriceDepends($OrderItemId)
    {
    	if($OrderItemId){
    		$table = $this->getTable('b3it_subscription/tierprice_depends');
    		$this->_getWriteAdapter()->delete($table,"benefit_orderitem_id='" . $OrderItemId ."'");
    		$this->_getWriteAdapter()->delete($table,"provider_orderitem_id='" . $OrderItemId ."'");
    	}
    }
    
    /**
     * Ermitteln wieviele AktiveSubscriptions der Kunde von diesem Produkt hat
     * @param integer $customer_id
     * @param integer $product_id
     * @return integer
     */
    public function getAcvitvProductSubscriptionsCount($customer_id,$product_id)
    {
    	if(!$customer_id) {return 0;}
    	if(!$product_id) {return 0;}
    	$sql = "
    	select count(item_id) from sales_flat_order_item
    	join b3it_subscription as subscription on subscription.current_orderitem_id=item_id and subscription.status=1
    	join sales_flat_order as sales_order on order_id=sales_order.entity_id AND customer_id = ".$customer_id
    	."	where product_id =". $product_id;
    	
    	$read = $this->_getReadAdapter();
    	$result = $read->fetchOne($sql);
    	
    	return intval($result);
    }
    
    public function switchTierPriceDepends($newOderItemId,$oldOrderItemId)
    {
    	if(!$newOderItemId) {return $this;}
    	if(!$oldOrderItemId) {return $this;}
    	
    	$table = $this->getTable('b3it_subscription/tierprice_depends');
    	//tierprice_depends_id, provider_orderitem_id, benefit_orderitem_id
    	$sql = "UPDATE " .$table . " SET provider_orderitem_id = ".$newOderItemId. " where provider_orderitem_id =". $oldOrderItemId;	
    	$this->_getReadAdapter()->query($sql);
    	
    	$sql = "UPDATE " .$table . " SET benefit_orderitem_id = ".$newOderItemId. " where benefit_orderitem_id =". $oldOrderItemId;
    	$this->_getReadAdapter()->query($sql);
    	
    	return $this;
    	
    }
    
    
}