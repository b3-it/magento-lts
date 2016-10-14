<?php

class Egovs_Base_Block_Adminhtml_Tools_Analyse_Sales_Order_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_taxRules = null;

    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_item_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        
       	$collection->getSelect()
       	->join(array('order'=>$collection->getTable('sales/order')),'main_table.order_id = order.entity_id',array('increment_id'=>'increment_id','orderstatus'=>'status','customer_id','customer_email'));
       	
       	//StoreIsolation
       	if(Mage::helper('egovsbase')->isModuleEnabled('Egovs_Isolation'))
       	{
       		$stores = Mage::helper('isolation')->getUserStoreViews();
       		if(count($stores) > 0)
       		{
       			$collection->getSelect()->where('store_group IN ('.implode(',',$stores).')');
       		}
       	}
        
        //die($collection->getSelect()->__toString());
        return parent::_prepareCollection();
    }

    
    protected function _afterLoadCollection()
    {
    	$data = array();
    	foreach($this->getCollection() as $item)
    	{
    		foreach($this->getColumns() as $col)
    		{
    			if($col->getTotal())
    			{
    				if(!isset($data[$col->getId()])){
    					$data[$col->getId()] = $item->getData($col->getIndex());
    				}else {
    					$data[$col->getId()] += $item->getData($col->getIndex());
    				}
    			}
    		}
    	}
    	
    	$this->setTotals(new Varien_Object($data));
    }
    
    
    protected function _prepareColumns()
    {

        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        	'totals_label' => Mage::helper('sales')->__('Totals')
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        	'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
        ));
        
        $this->addColumn('type',
        		array(
        				'header'=> Mage::helper('catalog')->__('Type'),
        				'width' => '150px',
        				'index' => 'product_type',
        				'type'  => 'options',
        				'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        		));
        

        $this->addColumn('sku', array(
        		'header' => Mage::helper('egovsbase')->__('sku'),
        		'index' => 'sku',
        		'width' => '100px',
        ));
        
        $this->addColumn('name', array(
        		'header' => Mage::helper('egovsbase')->__('Name'),
        		'index' => 'name',
        		//'width' => '100px',
        ));
        
        
        $this->addColumn('customer_id', array(
        		'header' => Mage::helper('egovsbase')->__('Customer#'),
        		'index' => 'customer_id',
        		'width' => '100px',
        ));
        
        $this->addColumn('customer_email', array(
        		'header' => Mage::helper('egovsbase')->__('Customer Email'),
        		'index' => 'customer_email',
        		//'width' => '100px',
        ));
        
        
        
        $this->addColumn('qty_ordered', array(
        		'header' => Mage::helper('egovsbase')->__('Qty'),
        		'index' => 'qty_ordered',
        		'width' => '100px',
        		'total' => 'sum'
        ));
  
        
        $this->addColumn('price', array(
        		'header' => Mage::helper('egovsbase')->__('Einzelpreis'),
        		'index' => 'price',
        		'width' => '100px',
        		'total' => 'sum'
        ));
        
        $this->addColumn('tax_percent', array(
        		'header' => Mage::helper('egovsbase')->__('Tax Percent'),
        		'index' => 'tax_percent',
        		'width' => '100px',
      
        ));
        
        $this->addColumn('tax_amount', array(
        		'header' => Mage::helper('egovsbase')->__('Tax Amount'),
        		'index' => 'tax_amount',
        		'width' => '100px',
        		'total' => 'sum'
        ));
        
        $this->addColumn('base_row_total_incl_tax', array(
        		'header' => Mage::helper('egovsbase')->__('Row Total'),
        		'index' => 'base_row_total_incl_tax',
        		'width' => '100px',
        		'total' => 'sum'
        ));
        


        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'orderstatus',
            'filter_index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));

        
        //$this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        //$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));
        $this->setCountTotals(true);
        return parent::_prepareColumns();
    }

    
   
    
    
    /**
     * FilterIndex Base Name
     *
     * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
     *
     * @return void
     */
    protected function _filterCreatedAtCondition($collection, $column) {
    	if (!$value = $column->getFilter()->getValue()) {
    		return;
    	}
    	 
    	$filters = $column->getFilter()->getValue();
    	 
    	$from = $filters['from'];
    	$to = $filters['to'];
    	 
    	
    	
    	if(isset($from)){
    		$this->getCollection()->addFieldToFilter('order.created_at', array('gteq' => $from->toString('yyyy-MM-dd')));
    	}
    	if(isset($to)){
    		$this->getCollection()->addFieldToFilter('order.created_at', array('lteq' => $to->toString('yyyy-MM-dd')));
    	}
    	 
    	//$condition = "(sales.created_at= ?)";
    	//$collection->getSelect()->where($condition, $value);
    	
    }
    
   
    protected function _prepareMassaction() {
    	$this->setMassactionIdField('entity_id');
    	$this->getMassactionBlock()->setFormFieldName('orderitems_ids');
    

    
    	Mage::dispatchEvent('adminhtml_sales_orderitem_grid_massaction_prepare_after', array('grid' => $this, 'massaction_block' =>  $this->getMassactionBlock() ));
    
    	return $this;
    }
  

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    
}
