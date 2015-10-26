<?php

class Slpb_Extstock_Block_Adminhtml_Journal_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


	
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockGrid');
		//$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		$lieferid = $this->getRequest()->getParam('lieferid');
		if($lieferid)
		{
			$filter = array();
			$filter['deliveryorder_increment_id'] = array('from'=>$lieferid);
			$this->setDefaultFilter($filter);
		}

	}

  
	

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('extstock/journal_collection');
		$this->setCollection($collection);
		return parent::_prepareCollection();		
	}
	
	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
	          'header'  => Mage::helper('extstock')->__('ID'),
	          'align'   =>'right',
	          'width'   => '30px',
			  'type'	=> 'text',
	          'index'   => 'journal_id',			  
			));
			
		$this->addColumn('deliveryorder_increment_id', array(
	          'header'  => Mage::helper('extstock')->__('Order ID'),
	          'align'   =>'right',
	          'width'   => '30px',
			  'type'	=> 'number',
	          'index'   => 'deliveryorder_increment_id',
			  
			));
		
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
	/*
		$this->addColumn('qty', array(
	          'header'  => Mage::helper('extstock')->__('Qty'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'number',
	          'index'   => 'qty',
			  
			));
		*/
		$this->addColumn('amount', array(
				'header'    	=> Mage::helper('extstock')->__('Ordered/Delivered'),
				'name'      	=> 'amount_to_order',
				'width'     	=> '60px',
				'type'      	=> 'number',
				'validate_class' => 'validate-number',
 				'index'     	=> 'qty',
				'index_id'	=> 'journal_id',
				'editable'  => true,
				'default'	=> 0,
				'sortable'	=> false,
				'filter'    => false,
				'renderer' 	=> 'extstock/adminhtml_journal_grid_renderer_delivered'
		));
		$this->addColumn('order', array(
	          'header'  => Mage::helper('extstock')->__('Order Date'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'date',
	          'index'   => 'date_ordered',
			  
			));
			
		$this->addColumn('delivered', array(
	          'header'  => Mage::helper('extstock')->__('Delivery Date'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'date',
	          'index'   => 'date_delivered',
			  
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

	protected function _prepareMassaction() 
	{
		$block = $this->getLayout()->createBlock('extstock/adminhtml_widget_grid_massaction','edtmassaction');
		$block->setJSClassName('SlpbStockMovmentGridMassaction');
		$this->setChild('massaction', $block);
		
		
		$this->setMassactionIdField('journal_id');
		$this->getMassactionBlock()->setFormFieldName('journal_id');
		
		$this->getMassactionBlock()->addItem('movement', array(
				'label'    => Mage::helper('extstock')->__('Switch to Delivered'),
				'url'      => $this->getUrl('adminhtml/extstock_journal/massDelivered'),
				
		));
		
		$this->getMassactionBlock()->addItem('delete', array(
				'label'    => Mage::helper('extstock')->__('Delete'),
				'url'      => $this->getUrl('*/*/massDelete'),
				'confirm'  => Mage::helper('extstock')->__('Are you sure?')
		));

		return $this;
	}

	public function getThisUrl($action)
	{
		return 'adminhtml/extstock_journal/'.$action;
	}
	
	/**
	 * Wichtig für Ajax
	 */ 
	public function getGridUrl()
    {
        return $this->getUrl('adminhtml/extstock_journal/grid', array('_current'=>true));
    }

    //damit kann nicht auf die Zeile geklickt werden!
    //weil dort das popup nicht funktioniert
	public function getRowUrl($row)
	{
		
		//return "popWin('".$this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()))."', 'windth=800,height=700,resizable=1,scrollbars=1');return false;";
		
		//if($this->_isStockMode())
		{
			//return $this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()));
		}
		return "";
	}


}