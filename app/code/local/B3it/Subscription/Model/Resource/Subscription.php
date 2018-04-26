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
class B3it_Subscription_Model_Resource_Subscription extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the subscription_subscription_id refers to the key field in your database table.
        $this->_init('b3it_subscription/subscription', 'id');
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

    public function saveField($object,$field)
    {
        if ($object->getId() && !empty($field))
        {
            $table = $this->getMainTable();
            $data = array($field => $object->getData($field));
            $this->_getWriteAdapter()->update($table, $data, 'id ='. intval($object->getId()));
        }

        return $this;
    }
  
    
}