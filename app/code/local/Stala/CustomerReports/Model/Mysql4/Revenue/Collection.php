<?php

/**
 *
 * Visitors reports REsourceCollection
 * 
 * @category   Egovs
 * @package    Egovs_Extreport
 */
class Stala_CustomerReports_Model_Mysql4_Revenue_Collection extends Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
{
	protected function _initSelect() {
    	parent::_initSelect();
        
    	$this->getSelect()
			->joinLeft(array('order_with_customer'=>$this->getTable('sales/order')), 'order_with_customer.entity_id = main_table.order_id',array("customer_id"))
    		->joinLeft(array('customer'=>$this->getTable('customer/entity')), 'customer.entity_id = order_with_customer.customer_id',array('customer_group_id'=>'customer.group_id'))
    	;
    	
//    	printf($this->getSelect()->assemble()."<br>");
    	
        return $this;
    }
}