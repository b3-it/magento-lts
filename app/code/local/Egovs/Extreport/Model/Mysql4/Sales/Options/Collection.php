<?php

/**
 *
 * Product Options reports resource collection
 * 
 * Kann keine Optionen die nur Textfelder sind anzeigen!
 * Zeigt nur Optionen mit Mehrfachauswahl (DropDown) an.
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Options_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	private $_categoryfilter = null;
	private $_categorynames = null;

	protected function _construct()
    {
        $this->_init('catalog/product_option');
    }
    
	private function getTablePrefix($val)
	{
		return Mage::getConfig()->getTablePrefix().$val;
	}

	/**
	 * 
	 * Add ordered items with state PROCESSING | COMPLETE
	 * Depends on Egovs_Extreport_Model_Mysql4_Sales_Pbc_Collection
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Pbc_Collection
	 */
	public function addPaidItemsWithOptions()
	{
		/** @var $paidItems Egovs_Extreport_Model_Mysql4_Sales_Pbc_Collection */
		$paidItems = Mage::getResourceModel('extreport/sales_pbc_collection');
				
		$this->getSelect()->reset(Zend_Db_Select::COLUMNS);
		$this->getSelect()
			->columns(array('product_id', 'qty'=>'sum(sales_order_invoices.qty)'))
			->join(
				array('option_title'=>$this->getTable('catalog/product_option_title')),
                '`option_title`.option_id=`main_table`.option_id',
                array('option_title'=>'title')
              )
            ->join(
				array('option_type_value'=>$this->getTable('catalog/product_option_type_value')),
                '`option_type_value`.option_id=`main_table`.option_id',
                array(
                	'option_type_id'=>'option_type_id',
                	'option_sku'=>'sku'
                )
              )
			->join(
				array('option_type_title'=>$this->getTable('catalog/product_option_type_title')),
                '`option_type_title`.option_type_id=`option_type_value`.option_type_id',
                array('value_title'=>'title')
              )            
            ->join(
				array('order_items'=>$this->getTable('sales/order_item')),
                '`order_items`.product_id=`main_table`.product_id and '
//                .$this->getConnection()->quoteInto('`order_items`.order_id IN (?)', $paidItems->getPaidOrderIds()).' and '
                .'`order_items`.product_options rlike concat(\'s:[0-9]+:"option_id";[[:space:]]*s:[0-9]+:"\',`main_table`.option_id,\'";[[:print:][:space:]]*s:[0-9]+:"option_value";[[:space:]]*s:[0-9]+:"((\',`option_type_value`.`option_type_id`,\')|(\',`option_type_value`.`option_type_id`,\',[,0-9]+)|([,0-9]+,\',`option_type_value`.`option_type_id`,\',[,0-9]+)|([,0-9]+,\',`option_type_value`.`option_type_id`,\'))";\')',
                array(
                	'order_id'=>'order_id',
                	'product_name'=>'name',
                	'sku'=>'sku',
                	'created_at'=>'created_at'
                )
              )
            ->join(
            	array('sales_order_invoices'=>$paidItems->getPaidOrdersSql()),
                '`sales_order_invoices`.product_id=`main_table`.product_id and `sales_order_invoices`.order_id = `order_items`.`order_id`',
                array('invoice_state'=>'state', 'store_id' => 'invoice_store_id')
              )
            ->group(array('main_table.product_id','main_table.option_id','option_type_value.option_type_id'))
//            ->order(array('product_id', 'option_title', 'value_title'))
        ;
        
		/* $sql = $this->getSelect()->assemble();
		echo $sql.'<br>';
		Mage::log($sql, Zend_Log::DEBUG, 'sql.log'); */
        
        return $this;
	}
	
	public function addQtyFilter($filter) {
		if (is_array($filter)) {
			$select = $this->getSelect();
			
			if(isset($filter['from']) && isset($filter['to'])) {
				$select->having('qty >='.$filter['from'].' AND qty <='.$filter['to'] );
           	}elseif (isset($filter['from'])){
           		$select->having('qty >='.$filter['from']);
           	}elseif (isset($filter['to'])){
           		$select->having('qty <='.$filter['to'] );
           	}	
           		
            return $this;
		}
		
		return $this;
	}
	
	protected function _initSelect()
	{
		parent::_initSelect();

		return $this;

	}
	
	public function getReportFull($from, $to)
    {
    	return $this;
    }
	
	/**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $this->_renderFilters();

        $cloneSelect = clone $this->getSelect();
        $cloneSelect->reset(Zend_Db_Select::ORDER);
        $cloneSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $cloneSelect->reset(Zend_Db_Select::LIMIT_OFFSET);

        
        $countSelect = new Zend_Db_Select($cloneSelect->getAdapter());
        $countSelect->from($cloneSelect, 'COUNT(*)');

//		$sql = $this->getSelect()->assemble();
//		echo $sql.'<br>';
//		Mage::log($sql, Zend_Log::DEBUG, 'sql.log');
		
        return $countSelect;
    }

	/**
	 * Set Store filter to collection
	 *
	 * @param array $storeIds
	 * @return Mage_Reports_Model_Mysql4_Product_Sold_Collection
	 */
	public function setStoreIds($storeIds)
	{
		$vals = array_values($storeIds);
		if (count($storeIds) >= 1 && $vals[0] != '') {
			$this->addFieldToFilter('invoice_store_id', array('in' => (array)$storeIds));
		}
		
		return $this;
	}

	public function addWebsiteFilter($filter)
	{
		$filter = implode(',',$filter);
		$this->getSelect()->where('invoice_store_id in ('.$filter.')');		
	}


	public function addStoreFilter($filter)
	{
		//var_dump($filter);
		$this->getSelect()->where('invoice_store_id = '.$filter);
	}

}