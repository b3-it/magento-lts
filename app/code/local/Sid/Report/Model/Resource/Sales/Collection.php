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
	protected $_los = null;
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
	        			array('order_date'=>'created_at', 'order_increment_id'=>'increment_id',"state",'customer_group_id','framecontract')
	        	)
	        	->join(array('adr'=>$this->getTable('sales/order_address')),'order.billing_address_id = adr.entity_id',
	        			array('billing_name' => 'CONCAT(COALESCE(firstname, ""), " ", COALESCE(lastname, ""))',
	        				  'billing_company' => 'CONCAT(COALESCE(company, ""), " ", COALESCE(company2, ""), " ", COALESCE(company3, ""))'))
	        	
		
        ;
        $this->getSelect()->where("product_type != '".Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE."'")
        		->group('main_table.product_id')
        		->columns(array('total_price' => 'SUM(qty_ordered*price)'))
        		->columns(array('total_price_base_row_total' => 'SUM(base_row_total)'))
        		->columns(array('total_price_base_row_total_incl_tax' => 'SUM(base_row_total_incl_tax)'))
				->columns(array('total_qty' => 'SUM(qty_ordered)'))
				->columns(array('all_dst' => 'GROUP_CONCAT(distinct `dst`.`value` order by `dst`.`value`)'))
        ;

        $this->addFieldToFilter('main_table.created_at', array('from' => $from, 'to' => $to));

        $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'dienststelle');
        if($attribute != null)
        {
        	$this->getSelect()->joinLeft(
                array('dst' => $attribute->getBackend()->getTable()),
                'order.customer_id=dst.entity_id AND attribute_id='.$attribute->getId(), array('dienststelle'=>'value')
            );
        }
        
        if($this->_los != null)
        {
        	$this->getSelect()->where('main_table.los_id='.intval($this->_los));
        }
        
	    if($this->_customer_group != null)
        {
        	$this->getSelect()->where('customer_group_id='.intval($this->_customer_group));
        }
        
		if($this->_dienststelle != null)
        {
        	$this->getSelect()->where($this->getConnection()->quoteInto('dst.value like ?',$this->_dienststelle));
        }
//         $eav = Mage::getResourceModel('eav/entity_attribute');
//         $qty = $eav->getIdByCode('catalog_product', 'framecontract_qty');
        
        $this->getSelect()
        	->join(array('los'=>$this->getTable('framecontract/los')), 'main_table.los_id = los.los_id',array('lostitle'=>'title'))
        	->join(array('contract'=>$this->getTable('framecontract/contract')), 'contract.framecontract_contract_id = los.framecontract_contract_id',array('contracttitle'=>'title'))
        	//->join(array('qty'=>$collection->getTable('catalog/product').'_int'), 'qty.entity_id=main_table.product_id AND qty.attribute_id ='.$qty, array('contract_qty'=>'value'))
        	->columns(array('contractlos' => "CONCAT(contract.title,' / ', los.title )") );
        

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
    
    public function setLos($value)
    {
    	if(!empty($value))
    	{
    		$this->_los = $value;
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