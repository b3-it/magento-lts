<?php
/**
 * ResourceModel Collection für Verlauf der Bestandsmengen
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection extends Mage_Reports_Model_Mysql4_Product_Collection
{
	/**
	 * Initialisiert den Report
	 * 
	 * @param string $from Von Datum
	 * @param string $to   Bis datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
	 * 
	 * @see Mage_Reports_Model_Mysql4_Product_Collection::_joinFields()
	 */
	protected function _joinFields($from = '', $to = '')
    {
    	$this->addAttributeToSelect('*')
			->addStockFlow($from, $to)
            ->setOrder('entity_id', 'asc')
		;
		
        return $this;
    }

    /**
     * Setzt die Datumsspanne der Collection
     *
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     *
     * @return Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
     */
    public function setDateRange($from, $to)
    {
        $this->_reset()
            ->_joinFields($from, $to);
        return $this;
    }

    /**
     * Setzt den StoreFilter der Collection
     *
     * @param array $storeIds Store IDs
     *
     * @return Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
     */
    public function setStoreIds($storeIds)
    {
        $storeId = array_pop($storeIds);
        $this->setStoreId($storeId);
        $this->addStoreFilter($storeId);
        return $this;
    }
    
    /**
     * Ermittelt den Bestandsverlauf
     * 
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     *
     * @return Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
     */
    public function addStockFlow($from = '', $to = '') {
    	$columns = array(
    					'qty_inward' => new Zend_Db_Expr("IF(`inwardsTab`.`inward` IS NULL,0,`inwardsTab`.`inward`)"),
    					'qty_outward' => new Zend_Db_Expr("IF(`ordered_qty` IS NULL,0,`ordered_qty`)")
    	);
    	
    	//Fügt alle Inwards mit Outwards im gleichen Zeitraum hinzu
    	$this->getSelect()->columns($columns);
    	$this->addInwardsQty($from, $to);
    	$this->addOrderedQty($from, $to, Varien_Db_Select::LEFT_JOIN);
    	
    	$firstSelect = $this->getSelect();
    	
    	//Neues Select Objekt erstellen!
    	$this->setConnection($this->getConnection());
    	$this->_initSelect();
    	
    	//Fügt alle Outwards mit Inwards im gleichen Zeitraum hinzu -> unbedingt nötig damit überall gleiche Spalten vorhanden
    	$this->getSelect()->columns($columns);
    	$this->addOrderedQty($from, $to);
    	$this->addInwardsQty($from, $to, Varien_Db_Select::LEFT_JOIN);
    	
    	$secondSelect = $this->getSelect();
    	
    	//Neues Select Objekt erstellen!
    	$this->setConnection($this->getConnection());
    	$this->getSelect()->from(
    							array('e' => new Zend_Db_Expr("({$firstSelect->assemble()} UNION {$secondSelect->assemble()})")),
    							array('*','diff' => '(`qty_inward`-`qty_outward`)')    							
    	);
    	
    	//die($this->getSelect()->assemble());
    	return $this;
    }
    
    /**
     * Fügt die Warenzugänge im angegebenen Zeitraum hinzu.
     * 
     * @param string $from Von Datum
     * @param string $to   Bis Datum 
     * @param string $type Join Type. default="Varien_Db_Select::INNER_JOIN"
     * 
     * @return Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
     */
    public function addInwardsQty($from = '', $to = '', $type=Varien_Db_Select::INNER_JOIN) {
    	$inwardsTab = array(
        				'inwardsTab' => new Zend_Db_Expr(
	        				"(SELECT `product_id`, SUM( `quantity_ordered` ) AS `inward`
							FROM {$this->getTable('extstock/extstock')} 
							WHERE `date_delivered` BETWEEN '$from' and '$to' 
							GROUP BY `product_id`)"
        				)
        );
        $cond = '`inwardsTab`.`product_id`=e.entity_id';
        $fields = '';
        
        switch ($type) {
        	case Varien_Db_Select::LEFT_JOIN:
        		$this->getSelect()->joinLeft($inwardsTab,
	        							$cond, //cond
	        							$fields
	        	);
	        	break;
	        
        	default:
        		$this->getSelect()->join($inwardsTab,
	        							$cond, //cond
	        							$fields
	        	);
        }
        
        return $this;
    }
    
    /**
     * Fügt die im angegebenen Zeitraum bestellten Waren hinzu
     * 
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     * @param string $type Join Type. default="Varien_Db_Select::INNER_JOIN"
     * 
     * @return Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
     * 
     * @see Mage_Reports_Model_Mysql4_Product_Collection::addOrderedQty()
     */
    public function addOrderedQty($from = '', $to = '', $type=Varien_Db_Select::INNER_JOIN) {
    	$outwardsTab = array(
    			'outwardsTab' => new Zend_Db_Expr(
    				"({$this->_addOrderedQty($from, $to)->assemble()})"
    			)
    	);
    	$fields = 'ordered_qty';
    	   	
    	switch ($type) {
        	case Varien_Db_Select::LEFT_JOIN:
        		$this->getSelect()->joinLeft($outwardsTab,
	        							'`outwardsTab`.`entity_id`=`inwardsTab`.`product_id`', //cond
	        							$fields
	        	);
	        	break;
	        
        	default:
        		$this->getSelect()->join($outwardsTab,
	        							'`outwardsTab`.`entity_id`=`e`.`entity_id`', //cond
	        							$fields
	        	);
        }
        
        return $this;
    }
    
    /**
     * Fügt die im angegebenen Zeitraum bestellten Waren hinzu
     * 
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     * 
     * @return Varien_Db_Select Enthält SELECT mit Menge der bestellten Produkte
     * 
     * @see app/code/core/Mage/Reports/Model/Mysql4/Product/Mage_Reports_Model_Mysql4_Product_Collection#addOrderedQty($from, $to)
     */
	protected function _addOrderedQty($from = '', $to = '')
    {
        /*
         * Revision [731] enthält ursprüngliche SQL-Anfrage die nach bestellten Artikeln fragt!
         */
    	
		$outwards = Mage::getResourceModel("extreport/sales_quantity_collection");
		$outwards->setDateRange($from, $to);
		$outwardsSelect = $outwards->getSelect();
		
		$qtyOrderedSelect = new Varien_Db_Select($outwards->getConnection());
        $qtyOrderedSelect->from(
            array('outward' => new Zend_Db_Expr("({$outwardsSelect->assemble()})")),
            array('ordered_qty' => "SUM(qty_shipped)",
            	'entity_id' => "product_id")
        );
        $qtyOrderedSelect->group('product_id');
        return $qtyOrderedSelect;
    }
}
