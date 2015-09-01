<?php

/**
 * ResourceModel Collection für Verkaufte (Shipped) Produkte
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Report
 * @author     	Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 */
class Sid_Report_Model_Resource_Sales_Collection extends Sid_Report_Model_Mysql4_Sales_Quantity_Collection

{
	protected $_customer_group = null;
	protected $_framecontract = null;
	protected $_dienststelle = null;
    
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
 	 * @return Sid_Report_Model_Resource_Sales_Collection
 	 */
	protected function _addSalesQuantity($from, $to)  {
    	//Es müssen alle Versendeten Produkte berücksichtigt werden (Teillieferungen etc.)!!!
        $state = array(Mage_Sales_Model_Order::STATE_PROCESSING, Mage_Sales_Model_Order::STATE_COMPLETE);
        /*
         * Bei ConfigurableProducts (CPs) wird auch immmer mit das entsprechende SimpleProduct (SP) in der
         * Tabelle abgelegt, diese enthalten aber bis auf den eigentlichen Produktnamen keine brauchbaren Informationen!
         */
        
  		$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'dienststelle');
        $this->getSelect()
	        	->join(
	        			array('order'=>$this->getTable('sales/order')),
	        			$this->getConnection()->quoteInto('order.entity_id = main_table.order_id AND order.state in (?)', $state),
	        			array('order_date'=>'created_at', "state",'customer_group_id','framecontract')
	        	)
		
        ;
        $this->getSelect()->where("product_type != '".Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE."'")
        		->group('main_table.product_id')
        		->columns(array('total_price' => 'SUM(qty_ordered*price)'))
				->columns(array('total_qty' => 'SUM(qty_ordered)'))
				->columns(array('all_dst' => 'GROUP_CONCAT(distinct `dst`.`value` order by `dst`.`value`)'))
        ;

        $this->addFieldToFilter('main_table.created_at', array('from' => $from, 'to' => $to));

        $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'dienststelle');
        if($attribute != null)
        {
        	$this->getSelect()->joinLeft(
                array('dst' => $attribute->getBackend()->getTable()),
                'customer_id=dst.entity_id AND attribute_id='.$attribute->getId(), array('dienststelle'=>'value')
            );
        }
        
        if($this->_framecontract != null)
        {
        	$this->getSelect()->where('framecontract='.intval($this->_framecontract));
        }
        
	    if($this->_customer_group != null)
        {
        	$this->getSelect()->where('customer_group_id='.intval($this->_customer_group));
        }
        
		if($this->_dienststelle != null)
        {
        	$this->getSelect()->where($this->getConnection()->quoteInto('dst.value like ?',$this->_dienststelle));
        }

        //die($this->getSelect()->__toString());
        return $this;
    }
    
    /**
     * Erstellt aus dem aktuellen Select ein SubSelect
     * 
     * @return Sid_Report_Model_Resource_Sales_Collection
     */
    protected function _createSubSelect()
    {
	    $this->getSelect()->columns(
		    		array('total_price' => 'SUM(qty_ordered*price)')
	   			)
    	;
    	
    	return $this;
    }
    
   
	
	/**
     * Setzt den StoreFilter der Collection
     *
     * @param array $storeIds Store IDs
     *
     * @return Sid_Report_Model_Resource_Sales_Collection
     */
    public function setStoreIds($storeIds)
    {
    	return $this;
    } 
        
    
    public function setCustomerGroup($value)
    {
    	if($value != '-1')
    	{
    		$this->_customer_group = $value;
    	}
    }
    
    public function setFramecontract($value)
    {
    	if($value != '-1')
    	{
    		$this->_framecontract = $value;
    	}
    }
    
   public function setDienststelle($value)
    {
    	if($value != '')
    	{
    		$this->_dienststelle = $value;
    	}
    }
    

 
    /**
     * Wird nach dem Laden aufgerufen
     * 
     * @return Sid_Report_Model_Resource_Sales_Collection
     * 
     * @see Mage_Sales_Model_Mysql4_Order_Item_Collection::_afterLoad()
     */
    /* protected function _afterLoad() {
    	foreach ($this->getItems() as $item) {
    		$item->setData('category', $this->_getCategoryNames($item->getData('category_ids')));
    	}
    	
    	return parent::_afterLoad();
    } */
   	
    
}