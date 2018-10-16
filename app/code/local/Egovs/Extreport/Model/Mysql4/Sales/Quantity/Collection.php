<?php

/**
 * ResourceModel Collection für Verkaufte (Shipped) Produkte
 * 
 * <strong>Achtung:</strong><br>
 * Diese Klasse wird ebenfalls von anderen Reports benutzt!
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author     	Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @see Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
 * @see Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection
 */
class Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection extends Mage_Sales_Model_Mysql4_Order_Item_Collection
{
	protected $_categoryfilter = null;
    protected $_storefilter = null;
    protected $_from = null;
    protected $_to = null;
	/**
	 * Fügt zu $val den optionalen Tabellenprefix hinzu
	 * 
	 * @param string $val Tabellenname
	 * 
	 * @return string
	 */
 	protected function _getTablePrefix($val) {
 		return Mage::getConfig()->getTablePrefix().$val;
 	}
    
 	/**
 	 * Erstellt die SQL Anweisung um Verkäufe zu ermitteln
 	 * 
 	 * @param string $from Von Datum
 	 * @param string $to   Bis Datum
 	 * 
 	 * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
 	 */
	protected function _addSalesQuantity($from, $to)  {
    	//Es müssen alle Versendeten Produkte berücksichtigt werden (Teillieferungen etc.)!!!
        $state = array(Mage_Sales_Model_Order::STATE_PROCESSING, Mage_Sales_Model_Order::STATE_COMPLETE);
        /*
         * Bei ConfigurableProducts (CPs) wird auch immmer mit das entsprechende SimpleProduct (SP) in der
         * Tabelle abgelegt, diese enthalten aber bis auf den eigentlichen Produktnamen keine brauchbaren Informationen!
         */
        
        if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	        $att = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('order', 'state');
	        $this->getSelect()
	        	->join(
	        			array('order'=>$this->getTable('sales/order')),
	        			'order.entity_id = main_table.order_id',
	        			array('order_date'=>'created_at', "store_id")
	        	)->join(
	        			array('order_state'=> $this->_getTablePrefix('sales_order_varchar')),
	        			$this->getConnection()->quoteInto("order.entity_id = order_state.entity_id AND order_state.attribute_id=?", $att).$this->getConnection()->quoteInto(" AND order_state.value in (?)", $state),
	        			array()
	        	)->joinLeft(
	        			array('e'=>$this->getTable('catalog/product')),
	        			'e.entity_id = main_table.product_id',
	        			array('category_ids'=>'category_ids')
        		)
	        ;
        } else {
        	$this->getSelect()->columns(array('category_ids' => new Zend_Db_Expr("GROUP_CONCAT(DISTINCT CONCAT_WS(', ', category_id))")));
        	$this->getSelect()->group('main_table.item_id');
        	$this->getSelect()
	        	->join(
	        			array('order'=>$this->getTable('sales/order')),
	        			$this->getConnection()->quoteInto('order.entity_id = main_table.order_id AND order.state in (?)', $state),
	        			array('order_date'=>'created_at', "state")
	        	);
        	
        	//if (!empty($this->_categoryfilter)) 
        	{
	        	$this->getSelect()->joinLeft(
        			array('e'=>$this->getTable('catalog/category_product')),
        			'e.product_id = main_table.product_id',
        			array('category_id')
        		);
        	}
        	
        }
        	//20110905::Frank Rochlitzer
			//Es darf hier kein Group verwendet werden, da sonst mehrere gleiche Artikel mit unterschiedlichen Downloads/Options unterschlagen werden
			//siehe Ticket #768
			//->group('main_table.product_id')
			//->group('order.entity_id')
        ;
        $compositeTypeIds     = Mage::getSingleton('catalog/product_type')->getCompositeTypes();
        $this->getSelect()->where("product_type NOT IN (?)",$compositeTypeIds);
        ;
        
        if($this->_storefilter)
        {
        	$this->addFieldToFilter('main_table.store_id', array('in' => (array)$this->_storefilter));
        }
        $this->_from = $from;
        $this->_to = $to;
        //20100414: fix für #351 und #356
        $this->addFieldToFilter('main_table.created_at', array('from' => $from, 'to' => $to));
//        die($this->getSelect()->__toString());
        return $this;
    }
    
    /**
     * Erstellt aus dem aktuellen Select ein SubSelect
     * 
     * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
     */
    protected function _createSubSelect() {
    	$select = new Varien_Db_Select($this->getConnection());
    	$sql = $this->getSelect()->assemble();
    	$select->from(array ('simple' => new Zend_Db_Expr("($sql)")))
	    	->joinLeft(array("super" => $this->getTable('sales/order_item')), "simple.parent_item_id = super.item_id", array())
		    	//Änderung bzgl Ticket #487
		    	->columns(
		    		array(
		    			'total_shipped'	=> 'SUM(
			    				IF(simple.`is_virtual` = 1,
			    					simple.`qty_invoiced` - simple.`qty_refunded`,
			    					IF(simple.parent_item_id IS NULL, simple.qty_shipped, super.qty_shipped)
			    				)
		    				)',
		    				'total_price' => 'SUM(
		    					IF(simple.`is_virtual` = 1,
		    						(simple.`qty_invoiced` - simple.`qty_refunded`) * simple.price,
		    						IF(simple.parent_item_id IS NULL, simple.qty_shipped, super.qty_shipped) * IF (super.price IS NULL, simple.price, super.price)
		    					)
		    				)',
		    				'total_ordered' => 'SUM(IF(simple.parent_item_id IS NULL, simple.qty_ordered, super.qty_ordered))'
		    		)
	    		)->group('product_id')
    	;
    	//Muss hier wegen group by stehen
    	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
    		//$select->columns(array('category_ids' => new Zend_Db_Expr("GROUP_CONCAT(DISTINCT CONCAT_WS(', ', category_id))")));
    	}
    	$mainSelect = new Varien_Db_Select($this->getConnection());
    	$sql = $select->assemble();
    	$mainSelect->from(new Zend_Db_Expr("($sql)"))
    	//         		->where("`total_shipped` > 0")// or (`is_virtual` = 1 and `qty_invoiced` > 0)")
    	;
    	//         Mage::log($mainSelect->assemble(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	//Wichtig sonst funnktioniert späterer Aufruf nicht mehr
    	$this->_select = $mainSelect;
    	
    	//Kategorienfiltern
    	if (!empty($this->_categoryfilter)) {
    		/*
    		 $this->getSelect()->join(array('cat_index' => $this->getTable('catalog/category_product_index')),
    		 		'cat_index.product_id=e.entity_id',array())
    		->where('cat_index.category_id='.$this->_categoryfilter);
    		*/
    		$this->getSelect()->where("FIND_IN_SET('".$this->_categoryfilter."',category_ids) > 0");    	
    	}
    	
    	//die($this->getSelect()->__toString());
    	return $this;
    }
    
    /**
     * Einsprungpunkt für Report
     * 
     * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
     */
    public function setDateRange($from, $to) {
    	$this->_from = $from;
    	$this->_to = $to;
    	
    	//Mage::log(sprintf('sql: %s', $this->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	return $this;
    }
	
	/**
     * Setzt den StoreFilter der Collection
     *
     * @param array $storeIds Store IDs
     *
     * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
     */
    public function setStoreIds($storeIds)
    {
        $vals = array_values($storeIds);
        
        $transport = new Varien_Object(array('storeids'=>$storeIds));
        Mage::dispatchEvent('report_collection_add_store_filter',array('transport'=>$transport,'collection'=> $this));
        $storeIds = $transport->getStoreids();
        
        
       // $this->_storefilter = array_values($storeIds);
        if (count($storeIds) >= 1 && $vals[0] != '') {
        	$this->_storefilter = $storeIds;
            //$this->addFieldToFilter('store_id', array('in' => (array)$storeIds));
        }
		$this->_reset() //Wichtig für Datefilter; Reset ruft initSelect() auf!!
    		->_addSalesQuantity($this->_from, $this->_to)
    		->_createSubSelect()
    		->setOrder('name', self::SORT_ORDER_ASC)
    	;
        
        return $this;
    }
    
    /**
     * Setzt den Filter für Kategorien
     * 
     * @param object $filter Filter
     * 
     * @return void
     */
    public function setCategoryFilter($filter) {
    	$this->_categoryfilter = $filter;
    }
 
    /**
     * Wird nach dem Laden aufgerufen
     * 
     * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
     * 
     * @see Mage_Sales_Model_Mysql4_Order_Item_Collection::_afterLoad()
     */
    protected function _afterLoad() {
    	foreach ($this->getItems() as $item) {
    		$item->setData('category', $this->_getCategoryNames($item->getData('category_ids')));
    	}
    	//die($this->getSelect()->__toString());
    	return parent::_afterLoad();
    }
   	
    /**
     * Liefert die Kategorienamen als String
     * 
     * @param array $ids Kategorien IDs
     * 
     * @return string
     */
   	protected function _getCategoryNames($ids) {   		
   		return Mage::helper('extreport')->getCategoryNames($ids);
   	}

   	
   	/**
   	 * Liefert die Kategorien als Option-Array
   	 * 
   	 * @return array
   	 */
   	public function getCategorysAsOptionArray()	{
   		return Mage::helper('extreport')->getCategorysAsOptionArray();
   	}
}