<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Mysql4_Invoice_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Mysql4_Address_Collection extends Mage_Sales_Model_Resource_Collection_Abstract
{
    private $_from;
    private $_to;
    private $_novirtual = null;
    private $_virtual = null;
   
	
 	protected function _initSelect()
    {
      
    	$helper = Mage::helper('ibewi');
    	$this->getSelect()->from(array('main_table' => $this->getMainTable()));    	
    	
    	$cols = new Zend_Db_Expr("
    	main_table.entity_id as xxx, parent_id, customer_address_id, main_table.quote_address_id, region_id, customer_id, fax, region, postcode, lastname, street, city, email, telephone, country_id, firstname, address_type, prefix, middlename, suffix, company, company2, company3, taxvat");
      	
    	$company = new Zend_Db_Expr("trim(concat(COALESCE(company,''),' ',COALESCE(company2,''), ' ',COALESCE(company3,''))) as ebewi_company");
    	$adressId = new Zend_Db_Expr("IFNULL(main_table.customer_address_id,CONCAT('OA',main_table.entity_id)) AS real_address_id");
    	$this->getSelect()
    	//->columns($cols)
    	->distinct()
    	->join(array('invoice'=>'sales_flat_invoice'),'invoice.order_id=main_table.parent_id AND invoice.state != '. Mage_Sales_Model_Order_Invoice::STATE_CANCELED ,array())
    	->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.parent_id',array('order_increment_id'=>'increment_id','order_customer_id'=>'customer_id',
    			'customer_prefix'=>'customer_prefix','customer_firstname'=>'customer_firstname','customer_lastname'=>'customer_lastname','customer_company'=>'customer_company'))
    	->columns($company)
    	->columns($adressId)
    	//->columns(array('address_id'=>'entity_id'))
    	;
    	
 	//die($this->getSelect()->__toString())   ;	
    	//$this->_novirtual = clone($this->getSelect());
    	$this->_virtual = clone($this->getSelect());

        
        return $this;
    }
	
	
    
    public function setSelectDates($from,$to)
    {
    	try
    	{
    		$this->_to =  $this->getDateTime($to,24);
    		$this->_from =  $this->getDateTime($from);
    	}
    	catch (Exception $ex)
    	{
    		$this->_from = "0";
    		$this->_to = "0";
    	}
    	 
    	 
    	$this->_buildSelect();
    }
    
    private function getDateTime($date,$add=0)
    {
    	$format = 'Y-m-d H:i:s';
    	$timestamp = Mage::getModel('core/date')->gmtTimestamp($date);
    
    	$timestamp += $add *60*60;
    
    	return "'" . date($format, $timestamp) ."'";
    
    }
    
    
    private function _buildSelect()
    {
    	
    	
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	
    	$virtualIncrementId = new Zend_Db_Expr("order.increment_id as ibewi_order_increment_id");
    	$NonvirtualIncrementId = new Zend_Db_Expr("CONCAT(order.increment_id,'_0') as ibewi_order_increment_id");
    	// $name = new Zend_Db_Expr("trim(concat(COALESCE(firstname, ''),' ',COALESCE(lastname,''))) as ebewi_name");
    	
    	$virtualFilter = new Zend_Db_Expr("(SELECT order_id FROM sales_flat_order_item  GROUP BY order_id)");
    	//$NotvirtualFilter = new Zend_Db_Expr("(SELECT order_id FROM sales_flat_order_item WHERE is_virtual = 0 GROUP BY order_id)");
    	
    	
    	 
    	$this->_virtual
    	->where('invoice.created_at >= ' .$this->_from)
    	->where('invoice.created_at < ' .$this->_to)
    	->columns($virtualIncrementId)
    	->columns(new Zend_Db_Expr("IF(main_table.address_type ='billing','billing','shipping') as ibewi_address_type"))
    	->join(array('item' => $virtualFilter),'item.order_id = order.entity_id',array())
    	->where(new Zend_Db_Expr("(address_type = 'billing' OR address_type = IF(is_virtual = 0, 'shipping','base_address'))"))
    	;




    	/*
    	$this->_novirtual
    	->where('invoice.created_at >= ' .$this->_from)
    	->where('invoice.created_at < ' .$this->_to)
    	->columns($NonvirtualIncrementId)
    	->columns(new Zend_Db_Expr("main_table.address_type as ibewi_address_type"))
    	->join(array('item' => $NotvirtualFilter),'item.order_id = order.entity_id',array())
    	->where("((address_type = 'billing') OR (address_type = 'shipping'))")
    	;
    	*/
    	 
    	$this->getSelect()
    	->reset()
    	->union(array($this->_virtual,$this->_novirtual),Zend_Db_Select::SQL_UNION_ALL);
    	
    	$sql = new Zend_Db_Expr("(". $this->_virtual->__toString().")");
//die($sql->__toString()) ;   	 
    	$this->getSelect()
    	->reset()
    	->from(array('main'=>$sql))
    	->order('ibewi_order_increment_id');
    	 
    	
    	
    	
    }
    
    
}




/*
 * 
 * SELECT `main`.* FROM 
 * (
 * SELECT DISTINCT `main_table`.*, `order`.`increment_id` AS `order_increment_id`, `order`.`customer_id` AS `order_customer_id`, 
 * `order`.`customer_prefix`, `order`.`customer_firstname`, `order`.`customer_lastname`, `order`.`customer_company`, trim(concat(COALESCE(company,''),' ',COALESCE(company2,''), ' ',COALESCE(company3,''))) as ebewi_company, 
 * `main_table`.`entity_id` AS `address_id`, CONCAT(order.increment_id,'_1') as entity_id FROM `sales_flat_order_address` AS `main_table` 
 * INNER JOIN `sales_flat_invoice` AS `invoice` ON invoice.order_id=main_table.parent_id INNER JOIN `sales_flat_order` AS `order` ON order.entity_id=main_table.parent_id 
 * INNER JOIN (SELECT order_id FROM sales_flat_order_item WHERE is_virtual = 1 GROUP BY order_id) AS `item` ON item.order_id = order.entity_id 
 * WHERE (invoice.created_at >= '2015-01-15 10:21:53') AND (invoice.created_at < '2015-01-16 10:21:53') AND (((address_type = 'billing') OR (address_type = 'base_address'))) 
 * UNION ALL 
 * SELECT DISTINCT `main_table`.*, `order`.`increment_id` AS `order_increment_id`, `order`.`customer_id` AS `order_customer_id`, 
 * `order`.`customer_prefix`, `order`.`customer_firstname`, `order`.`customer_lastname`, `order`.`customer_company`, trim(concat(COALESCE(company,''),' ',COALESCE(company2,''), ' ',COALESCE(company3,''))) as ebewi_company,
 *  `main_table`.`entity_id` AS `address_id`, CONCAT(order.increment_id,'_0') as entity_id FROM `sales_flat_order_address` AS `main_table` 
 *  INNER JOIN `sales_flat_invoice` AS `invoice` ON invoice.order_id=main_table.parent_id 
 *  INNER JOIN `sales_flat_order` AS `order` ON order.entity_id=main_table.parent_id 
 *  INNER JOIN (SELECT order_id FROM sales_flat_order_item 
 *  WHERE is_virtual = 1 GROUP BY order_id) AS `item` ON item.order_id = order.entity_id WHERE (invoice.created_at >= '2015-01-15 10:21:53') AND (invoice.created_at < '2015-01-16 10:21:53') 
 *  AND (((address_type = 'billing') OR (address_type = 'shipping')))) AS `main`
 */