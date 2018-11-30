<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Mysql4_Abo
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_Mysql4_Abo extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the abo_abo_id refers to the key field in your database table.
        $this->_init('dwd_abo/abo', 'abo_id');
    }
    
    
    public function removeTierPriceDepends($OrderItemId)
    {
    	if($OrderItemId){
    		$table = $this->getTable('dwd_abo/tierprice_depends');
    		$this->_getWriteAdapter()->delete($table,"benefit_orderitem_id='" . $OrderItemId ."'");
    		$this->_getWriteAdapter()->delete($table,"provider_orderitem_id='" . $OrderItemId ."'");
    	}
    }
    
    /**
     * Ermitteln wieviele AktiveAbos der Kunde von diesem Produkt hat
     * @param integer $customer_id
     * @param integer $product_id
     * @return integer
     */
    public function getAcvitvProductAbosCount($customer_id,$product_id)
    {
    	if(!$customer_id) {return 0;}
    	if(!$product_id) {return 0;}
    	$sql = "
    	select count(item_id) from sales_flat_order_item
    	join dwd_abo as abo on abo.current_orderitem_id=item_id and abo.status=1
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
    	
    	$table = $this->getTable('dwd_abo/tierprice_depends');
    	//tierprice_depends_id, provider_orderitem_id, benefit_orderitem_id
    	$sql = "UPDATE " .$table . " SET provider_orderitem_id = ".$newOderItemId. " where provider_orderitem_id =". $oldOrderItemId;	
    	$this->_getReadAdapter()->query($sql);
    	
    	$sql = "UPDATE " .$table . " SET benefit_orderitem_id = ".$newOderItemId. " where benefit_orderitem_id =". $oldOrderItemId;
    	$this->_getReadAdapter()->query($sql);
    	
    	return $this;
    	
    }
    
    
}