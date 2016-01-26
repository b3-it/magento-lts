<?php

class Slpb_Extstock_Block_Adminhtml_Ordersheet_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


	
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstock2_ordersheetGrid');
		//$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		
		
		

	}

  
	

	protected function _prepareCollection()
	{
		$lieferid = $this->getRequest()->getParam('lieferid');
		$collection = Mage::getResourceModel('extstock/journal_collection');
		$exp = new Zend_Db_Expr('format(qty_ordered / size.value,2)  as package ');
		$PackageSize = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'packaging_size');
		$collection->getSelect()
				   ->joinleft(array('size'=>'catalog_product_entity_varchar'),'size.entity_id = main_table.product_id AND size.attribute_id='.intval($PackageSize->getId()),array('size'=>'value'))
				   ->columns($exp)
				   ->join('extstock2_stock_order','extstock2_stock_order.extstock_stockorder_id=main_table.deliveryorder_increment_id','desired_date')
				   ->where('deliveryorder_increment_id=?',intval($lieferid));
//die($collection->getSelect()->__toString());		
		$this->setCollection($collection);
		return parent::_prepareCollection();		
	}
	
	protected function _prepareColumns()
	{
	
			/*
		$this->addColumn('id', array(
	          'header'  => Mage::helper('extstock')->__('Bestellscheinnr.'),
	          'align'   =>'right',
	          'width'   => '30px',
			  'type'	=> 'number',
	          'index'   => 'deliveryorder_increment_id',
			));
			*/
		$this->addColumn('product', array(
	          'header'  => Mage::helper('extstock')->__('Product'),
	          'align'   =>'right',
	          //'width'   => '30px',
			  'type'	=> 'text',
	          'index'   => 'productname',
			'filter_index' => 'att.value'
			  
			));
		$this->addColumn('sku', array(
	          'header'  => Mage::helper('extstock')->__('Sku'),
	          'align'   =>'right',
	          'width'   => '70px',
			  'type'	=> 'text',
	          'index'   => 'sku',
			  
			));
	
		$this->addColumn('package', array(
	          'header'  => Mage::helper('extstock')->__('Package'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'number',
	          'index'   => 'package',
			  
			));
			
		$this->addColumn('qty_ordered', array(
	          'header'  => Mage::helper('extstock')->__('Qty Ordered'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'number',
	          'index'   => 'qty_ordered',
			  
			));
			
		$this->addColumn('qty', array(
	          'header'  => Mage::helper('extstock')->__('Qty Delivered'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'number',
	          'index'   => 'qty',
			  
			));
		

			
			
		$this->addColumn('order', array(
	          'header'  => Mage::helper('extstock')->__('Date Ordered'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'date',
	          'index'   => 'date_ordered',
			  
			));
			
	$this->addColumn('desired_date', array(
	          'header'  => Mage::helper('extstock')->__('Desired Date'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'date',
	          'index'   => 'desired_date',
			  
			));
		
		$stock = Mage::getModel('extstock/stock');	
		
		$this->addColumn('output_stock_id', array(
	          'header'  => Mage::helper('extstock')->__('From'),
	          'align'   =>'right',
	          'width'   => '100px',
			  'type'	=> 'options',
			  'options' => $stock->getCollection()->asOptionsArray(),
	          'index'   => 'output_stock_id',
			  
			));
		$this->addColumn('input_stock_id', array(
	          'header'  => Mage::helper('extstock')->__('To'),
	          'align'   =>'right',
	          'width'   => '100px',
			  'type'	=> 'options',
			  'options' => $stock->getCollection()->asOptionsArray(),
	          'index'   => 'input_stock_id',
			  
			));
	
		$this->addColumn('status', array(
				'header'  => Mage::helper('extstock')->__('Status'),
				'align'   =>'right',
				'width'   => '100px',
				'type'	=> 'options',
				'options' => Slpb_Extstock_Model_Journal::getStatusOptionsArray(),
				'index'   => 'status',
					
		));
			
		$this->addExportType('*/*/exportCsv', Mage::helper('extstock')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('extstock')->__('XML'));	
		return parent::_prepareColumns();
	}


	


	
	/**
	 * Wichtig für Ajax
	 */ 
	public function getGridUrl()
    {
        return $this->getUrl('adminhtml/extstock_ordersheet/grid', array('_current'=>true));
    }

  


}