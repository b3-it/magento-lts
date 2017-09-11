<?php

/**
 * Bezahlte Produkte mit Kundeninformationen Reports ResourceCollection
 * 
 * <p>
 * <strong>Nicht zu Magento 1.3 kompatibel</strong>
 * </p>
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Extreport_Model_Mysql4_Sales_Pbc_Collection extends Mage_Sales_Model_Resource_Order_Collection
{
	protected $_categoryfilter = null;
	protected $_categorynames = null;

	protected function _getTablePrefix($val) {
		return Mage::getConfig()->getTablePrefix().$val;
	}

	/**
	 * Add invoiced items with state PAID
	 * 
	 * @param Varien_Date $from Von Datum
	 * @param Varien_Date $to   Bis Datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Pbc_Collection
	 */
	protected function _addPaidItems($from, $to)
	{
		$this->getSelect()
			->reset(Zend_Db_Select::COLUMNS)
			->columns(
				array(
					'order_id' => 'entity_id',
					'order_increment_id' => 'increment_id',
					'state',
					'store_id',
					'created_at',
					'customer_id'					
				)
			)
		;
		
		$this->addFilterToMap('created_at', 'main_table.created_at');
		$this->addFilterToMap('store_id', 'main_table.store_id');
		
		$this->getSelect()
			////second join condition, es werden nur die Hauptprodukte betrachtet
			->join(array('order_items' => $this->getTable('sales/order_item')),
				'order_id=main_table.entity_id AND order_items.parent_item_id is null',
				array(
					'product_id' => 'product_id',
					'qty' => 'qty_ordered',
					'sku' => 'sku',
					'name' => 'name'
				)
			)
			->joinLeft(array('order_address' => $this->getTable('sales/order_address')),
				'order_address.entity_id=billing_address_id',
				array(
					'firstname',
					'lastname',
					'email',
					'company',
					'company2',
					'company3',
					'street',
					'city',
					'postcode'				
				)
			)
		;

		$this                 
            ->addFieldToFilter('created_at', array('from' => $from, 'to' => $to))
            ->addFieldToFilter('state',
            	array(
            		array('eq' => Mage_Sales_Model_Order::STATE_PROCESSING),
            		array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE)
            	)
            )
        ;
        
        $this->addExpressionFieldToSelect('fullQty', "SUM({{qty}})", array('qty' => 'qty_ordered'));
		$this->addExpressionFieldToSelect('fullName', "concat(COALESCE({{firstname}},''), ' ', COALESCE({{lastname}},''))", array('firstname' => 'firstname', 'lastname' => 'lastname'));
		$this->addExpressionFieldToSelect('fullCompany', "concat(COALESCE({{company}},''), ' ', COALESCE({{company2}},''), ' ', COALESCE({{company3}},''))", array('company' => 'company', 'company2' => 'company2', 'company3' => 'company3'));
		$this->addExpressionFieldToSelect('fullAddress', "concat(COALESCE({{street}},''), ' ', COALESCE({{city}},''), ' ', COALESCE({{postcode}},''))", array('street' => 'street', 'city' => 'city', 'postcode' => 'postcode'));
		$this->getSelect()->group(array('product_id', 'sku', 'fullCompany', 'fullName', 'fullAddress'));
		$this->addExpressionFieldToSelect('names', "group_concat(DISTINCT concat(COALESCE({{firstname}},''), ' ', COALESCE({{lastname}},'')))", array('firstname' => 'firstname', 'lastname' => 'lastname'));
		$this->addExpressionFieldToSelect('companyNames', "group_concat(DISTINCT concat(COALESCE({{company}},''), '<br>', COALESCE({{company2}},''), '<br>', COALESCE({{company3}},'')))", array('company' => 'company', 'company2' => 'company2', 'company3' => 'company3'));
		$this->addExpressionFieldToSelect('postAddress', "group_concat(DISTINCT concat(COALESCE({{street}},''), '<br>', COALESCE({{city}},''), ' ', COALESCE({{postcode}},'')))", array('street' => 'street', 'city' => 'city', 'postcode' => 'postcode'));
		
        /*$this->getSelect()->columns("IF (group_id IS NULL,0,group_id) as group_id") //Wichtig für Gruppenfilter
        				->joinLeft(array("customer_grps"=>$this->getTable('customer_group')),
        							"IF (group_id IS NULL, customer_group_id=0, customer_group_id=group_id)",
        							'customer_group_code'
        							)
        ;
        $group_id = Mage::registry('cgroup');
        if (isset($group_id)) {
        	$this->getSelect()->having("group_id = $group_id");
        }*/
 //die($this->getSelect()->__toString());       
        return $this;
	}
	
	/**
	 * Liefert alle Bezahlten Bestellungen
	 * 
	 * @return Zend_Db_Expr
	 */
	public function getPaidOrdersSql() {
		$this->getSelect()
			->reset(Zend_Db_Select::COLUMNS)
			->columns(
				array(
					'order_id' => 'entity_id',
					'order_increment_id' => 'increment_id',
					'invoice_store_id' => 'store_id',
					'state',
				)
			)
		;
		$this->getSelect()
			//second join condition, es werden nur die Hauptprodukte betrachtet
			->join($this->getTable('sales/order_item'), 'order_id=entity_id AND parent_item_id is null',
				array(
					'product_id' => 'product_id',
					'qty' => 'qty_ordered',
					'sku' => 'sku',
					'name' => 'name'
				)
			)
		;
		$this
            ->addFieldToFilter('state',
            	array(
            		array('eq' => Mage_Sales_Model_Order::STATE_PROCESSING),
            		array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE)
            	)
            )
        ;
        $this->getSelect()
            //entity_id entspricht order_id
            ->group(array('entity_id','product_id',));
        ;
                
		return new Zend_Db_Expr("({$this->getSelect()->assemble()})");
	}

	/**
	 * Einsprungpunkt für Report
	 * 
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Pbc_Collection
	 */
	public function setDateRange($from, $to) {
		$this->_reset() //Wichtig für Datefilter; Reset ruft initSelect() auf!!
			->_addPaidItems($from, $to)
			->setOrder('name', self::SORT_ORDER_ASC)
			->setOrder('companyNames', self::SORT_ORDER_ASC)
			->setOrder('names', self::SORT_ORDER_ASC)
		;
		 
//		$sql = $this->getSelect()->assemble();
//		echo $sql.'<br>';
//		Mage::log($sql, Zend_Log::DEBUG, 'sql.log');
		return $this;
	}

	/**
	 * Set Store filter to collection
	 *
	 * @param array $storeIds Store IDs
	 * 
	 * @return Mage_Reports_Model_Mysql4_Product_Sold_Collection
	 */
	public function setStoreIds($storeIds) {
		$vals = array_values($storeIds);
		if (count($storeIds) >= 1 && $vals[0] != '') {
			$this->addFieldToFilter('store_id', array('in' => (array)$storeIds));
		}

		return $this;
	}

	public function setCategoryFilter($filter) {
		$this->_categoryfilter = $filter;
	}

	public function getCategorysAsOptionArray() {
		$collection = Mage::getModel('catalog/category')
			->getCollection()
			->addAttributeToSelect('name')
			->setOrder('name', Varien_Data_Collection_Db::SORT_ORDER_ASC)
			->load();
		$res = array();
		foreach ($collection->getItems() as $item) {
			if ($item->getData('level')+0 > 0) {
				$res[$item->getData('entity_id')] = $item->getData('name');
			}
		}
		return $res;
	}
}