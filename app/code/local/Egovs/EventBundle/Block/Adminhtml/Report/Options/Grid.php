<?php

/**
 * Adminhtml total visitors
 *
 * @category   Egovs
 * @package    Egovs_Extreport
 */
class Egovs_EventBundle_Block_Adminhtml_Report_Options_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct() {
		parent::__construct();
		$this->setId('eventbundleOptionsGrid');
		//$this->setDefaultSort('product_name');
		$this->setDefaultDir('asc');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		$this->setVarNameFilter('customer_filter');
		$this->_controller = 'adminhtml_report';

		$this->addExportType('*/*/exportOptionsCsv','CSV');
		$this->addExportType('*/*/exportOptionsExcel','XML (Excel)');
	}

	protected function _getStore() {
		$storeId = (int) $this->getRequest()->getParam('store', 0);
		return Mage::app()->getStore($storeId);
	}

	protected function _prepareCollection()	{
		$collection = Mage::getSingleton('eventbundle/report_options')->getCollection();

		//echo($collection->getSelect()->__toString());	die();	 
		 
		if ($this->getRequest()->getParam('store')) {
			$storeIds = array($this->getParam('store'));
			$collection->addStoreFilter($storeIds[0]);
		} else if ($this->getRequest()->getParam('website')){
			$storeIds = Mage::app()->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
			$collection->addWebsiteFilter($storeIds);
		} else if ($this->getRequest()->getParam('group')){
			$storeIds = Mage::app()->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
			$collection->addWebsiteFilter($storeIds);
		} else {
			$storeIds = array('');
		}
		 
		$this->setCollection($collection);

		parent::_prepareCollection();

		return $this;
	}

	
	protected function _afterLoadCollection()
	{
		parent::_afterLoadCollection();
		$collection = $this->getCollection();
		foreach($collection->getOptionLabels() as $label)
		{
			
			$this->addColumn('eventoption_'.$label, array(
					'header'    => Mage::helper('sales')->__($label),
					'index'     => 'eventoption_'.$label,
					'filter'    => false,
      				'sortable'  => false
					//'filter_index'	=> 'order_items.name',
			));
		}
	}
	
	
	protected function _filterQtyCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addQtyFilter($value);
    }

	protected function _prepareColumns() {
		
		$this->addColumn('sku', array(
            'header'    =>Mage::helper('catalog')->__('SKU'),
            'index'     => 'sku',
			'width'	=> 200,
        ));
        
		$this->addColumn('created_at', array(
            'header'    => Mage::helper('sales')->__('Ordered'),
            'index'     => 'created_at',
			'type'		=> 'date',
			'filter_index'	=> 'order_items.created_at',
			'width'	=> 80,
        ));
        
	
		
		$this->addColumn('order',
				array(
						'header'=> Mage::helper('sales')->__('Order'),
						'width' => '80px',
						'index' => 'order_increment_id',
						'filter_index'=>'order_increment_id',
		
						'link_index' => 'order_entity_id',
						'link_param' =>'order_id',
						'link_url' => 'adminhtml/sales_order/view',
						'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
		
				));
		
        $this->addColumn('product_name', array(
            'header'    => Mage::helper('sales')->__('Product Name'),
            'index'     => 'name',
        	//'filter_index'	=> 'order_items.name',
        ));
        

        $this->addColumn('qty', array(
            'header'    => Mage::helper('sales')->__('Qty'),
            'index'     => 'qty_ordered',
//        	'filter_index' => 'sales_order_invoices.qty',
	//		'filter_condition_callback' => array($this, '_filterQtyCondition'),
        	'type'		=> 'number',
        	'total'     => 'sum',
        ));

		//$this->setCountTotals(true);
		return parent::_prepareColumns();
	}
	
	
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'options'));
	}
}