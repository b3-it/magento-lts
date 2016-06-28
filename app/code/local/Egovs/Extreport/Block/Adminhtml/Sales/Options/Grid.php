<?php

/**
 * Adminhtml Produkte mit Optionen
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Options_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct() {
		parent::__construct();
		$this->setId('productOptionsGrid');
		$this->setDefaultSort('product_name');
		$this->setDefaultDir('asc');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		$this->setVarNameFilter('customer_filter');
		$this->_controller = 'adminhtml_sales';

		$this->addExportType('*/*/exportOptionsCsv','CSV');
		$this->addExportType('*/*/exportOptionsExcel','XML (Excel)');
	}

	protected function _getStore() {
		$storeId = (int) $this->getRequest()->getParam('store', 0);
		return Mage::app()->getStore($storeId);
	}

	protected function _prepareCollection()	{
		$collection = Mage::getSingleton('extreport/sales_options')->getCollection();
		 
		$collection->addPaidItemsWithOptions();		 
		 
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

	protected function _filterQtyCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addQtyFilter($value);
    }

	protected function _prepareColumns() {
		/*$this->addColumn('sku', array(
            'header'    =>Mage::helper('catalog')->__('SKU'),
            'index'     => 'sku',
        )); */
        
		$this->addColumn('created_at', array(
            'header'    => Mage::helper('sales')->__('Ordered'),
            'index'     => 'created_at',
			'type'		=> 'date',
			'filter_index'	=> 'order_items.created_at'
        ));
        
        $this->addColumn('product_name', array(
            'header'    => Mage::helper('sales')->__('Product Name'),
            'index'     => 'product_name',
        	'filter_index'	=> 'order_items.name',
        ));
        
        $this->addColumn('option_title', array(
            'header'    => Mage::helper('extreport')->__('Option Title'),
            'index'     => 'option_title',
        	'filter_index'	=> 'option_title.title'
        ));
        
        $this->addColumn('value_title', array(
            'header'    => Mage::helper('extreport')->__('Option Name'),
            'index'     => 'value_title',
        	'filter_index'	=> 'option_type_title.title'
        ));
        
        $this->addColumn('qty', array(
            'header'    => Mage::helper('sales')->__('Qty'),
            'index'     => 'qty',
//        	'filter_index' => 'sales_order_invoices.qty',
			'filter_condition_callback' => array($this, '_filterQtyCondition'),
        	'type'		=> 'number',
        	'total'     => 'sum',
        ));

		/*$this->addColumn('bestellstatus',
		array(
                'header'=> Mage::helper('catalog')->__('Order Status'),
                'width' => '80px',
                'index' => 'bestellstatus',
             	'type'  => 'options',
		//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
                'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
		//'filter_index' => 'order_state.value'
		));*/

		$this->setCountTotals(true);
		return parent::_prepareColumns();
	}
	
	protected function _afterLoadCollection()
    {
        $totalObj = new Mage_Reports_Model_Totals();
        $this->setTotals($totalObj->countTotals($this,0,0));
    }

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'options'));
	}
}