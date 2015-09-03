<?php

class Slpb_Extstock_Model_Mysql4_Detail_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
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
            if(is_array($rows))
            {
            	$this->_totalRecords = count($rows);
            }
            
        }
        return intval($this->_totalRecords);
    }
	

	
	protected function _initSelect()
	{
		//parent::_initSelect();
		$select = $this->getSelect();
		
		/*
		$exp = new Zend_Db_Expr('
		(
			SELECT product_id, input_stock_id as stock_id, sum(qty) as sum_qty FROM extstock2_stock_journal as t1 where status='.Slpb_Extstock_Model_Journal::STATUS_DELIVERED.' group by input_stock_id, product_id
			union
			SELECT product_id, output_stock_id as stock_id, (sum(qty)*-1) as sum_qty FROM extstock2_stock_journal as t2 where status='.Slpb_Extstock_Model_Journal::STATUS_DELIVERED.' group by output_stock_id, product_id
			union
			SELECT ex.product_id, so.stock_id, (sum(so.qty_ordered) * -1) as sum_qty FROM extstock2_sales_order as so
			join extstock2 as ex on ex.extstock_id=so.extstock_id group by stock_id, product_id
			union
			SELECT product_id, stock_id, sum(quantity_ordered) as sum_qty FROM extstock2 where status= 2 group by stock_id, product_id 
		)');
		*/
		$exp = new Zend_Db_Expr(sprintf('(SELECT product_id, stock_id, sum(quantity) as sum_qty FROM %s where status= 2 group by product_id, stock_id)', $this->getTable('extstock/extstock')));
		
		$select->from(array('main_table'=>$exp),array())
			->columns('main_table.product_id')
			->columns('main_table.stock_id')
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
			
			
			
		//die($select->__toString());
	}
	
	public function suppressLossStore()
	{
		$this->getSelect()->where('stock.type<>'.Slpb_Extstock_Model_Stock::STORETYP_LOSS);	
		return $this;
	}
	
	public function addWarningsFilter()
	{
		$this->getSelect()->having('stock.default_warning_qty >= sum(main_table.sum_qty)');
		return $this;	
	}
	
	public function addTotalQty()
	{
		$this->getSelect()
		->join(array('csi'=>'cataloginventory_stock_item'), "csi.product_id = main_table.product_id", array('total_qty'=>'qty'));
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