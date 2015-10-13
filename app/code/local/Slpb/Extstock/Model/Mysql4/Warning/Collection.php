<?php

class Slpb_Extstock_Model_Mysql4_Warning_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

	public function _construct()
	{
		parent::_construct();
		$this->_init('extstock/extstock');
	}


	public function getSize()
    {
        if (is_null($this->_totalRecords)) {
            $sql = $this->getSelect();
            $rows = $this->getConnection()->fetchAll($sql, $this->_bindParams);
            $this->_totalRecords = 0;
            if (is_array($rows)) {
            	$this->_totalRecords = count($rows);
            }
            
        }
        return intval($this->_totalRecords);
    }
	

	
	protected function _initSelect()
	{
// 		parent::_initSelect();
		$select = $this->getSelect();
		
		/*
		SELECT product_id, stock_id, sum(quantity) as sum_qty
		from
		(
		  select product_id, stock_id, quantity
		  FROM extstock2 where status=2
		  union
		  SELECT entity_id as product_id, stock_id, 0 FROM catalog_product_entity
		  join extstock2_stock on type <> 1
		) as t1
		group by product_id, stock_id
		*/
		//$exp = new Zend_Db_Expr(sprintf('(SELECT product_id, stock_id, sum(quantity) as sum_qty FROM %s where status= 2 group by product_id, stock_id)', $this->getTable('extstock/extstock')));
		$exp = new Zend_Db_Expr('(SELECT product_id, stock_id, sum(quantity) as sum_qty, concat(product_id,"_",stock_id) as id
		from
		(
		  select product_id, stock_id, quantity
		  FROM extstock2 where status=2
		  union
		  SELECT entity_id as product_id, stock_id, 0 FROM catalog_product_entity
		  join extstock2_stock on type <> 1
		) as t1
		group by product_id, stock_id)');
		$select->from(array('main_table'=>$exp),array())
			->columns('main_table.product_id')
			->columns('main_table.stock_id')
			->columns('main_table.id')
			->columns(array('qty'=>'sum(main_table.sum_qty)'))
			->group('main_table.stock_id')
			->group('main_table.product_id')
			->join(array('e'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity'),'main_table.product_id = e.entity_id',array('sku'))
			->join(array('att'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity_varchar'),'att.entity_id = main_table.product_id',array('productname'=>'value'))
			->join(array('ea'=>$this->getTable('eav/attribute')),'att.attribute_id=ea.attribute_id',array())
			->join(array('et'=>$this->getTable('eav/entity_type')),'ea.entity_type_id = et.entity_type_id',array())
			->join(array('stock'=>'extstock2_stock'),'stock.stock_id = main_table.stock_id','*')
			->where("et.entity_type_code = 'catalog_product'")
			->where("ea.attribute_code = 'name'");
			
			
			
// 		Mage::log(sprintf("slpb detail/collection:\n%s",$select->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	}
	
	public function suppressLossStore()
	{
		$this->getSelect()->where('stock.type<>'.Slpb_Extstock_Model_Stock::STORETYP_LOSS);	
		return $this;
	}
	
	public function addWarningsFilter() {
		$this->getSelect()->having('stock.default_warning_qty >= sum(main_table.sum_qty)');
		return $this;	
	}
	
	public function addTotalQty() {
		//$this->getSelect()
		//->join(array('csi'=>'cataloginventory_stock_item'), "csi.product_id = main_table.product_id", array('total_qty'=>'qty'));
		
		
		$sql = "(SELECT product_id as pid, sum(quantity) as total_qty FROM ".$this->getTable("extstock")." AS tbl2
				inner join ".$this->getTable('extstock/stock')." as s1 on s1.stock_id=tbl2.stock_id AND s1.type <>".Slpb_Extstock_Model_Stock::STORETYP_LOSS."
				GROUP BY product_id)";
	//die($sql);
		$this->getSelect()->join(array("csi"=>new Zend_Db_Expr($sql)),"csi.pid=main_table.product_id", array('total_qty'));
		
		return $this;
	}
	
	/**
	 * Retrive all ids for collection
	 *
	 * @return array
	 */
	public function getAllIds() {
		$idsSelect = clone $this->getSelect();
		$idsSelect->reset(Zend_Db_Select::ORDER);
		$idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
		$idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
		//$idsSelect->reset(Zend_Db_Select::COLUMNS);
		$idsSelect->from(null,
				'main_table.' . 'product_id'
		);
		return $this->getConnection()->fetchCol($idsSelect);
	}
	
}