<?php

class Slpb_Extstock_Block_Adminhtml_Warning_Grid extends Mage_Adminhtml_Block_Widget_Grid
{



	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockWarningGrid');
		//$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		//$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);

// 		$this->setIdFieldName('product_id');
		//$this->setDefaultFilter(array('limit_exceeded' => 1));
		
		
	}





	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('extstock/warning_collection');
		$collection
			->suppressLossStore()
// 				->addWarningsFilter()
				->addTotalQty()
		;
		$PackageSize = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'packaging_size');
		$collection->getSelect()
				   ->joinleft(array('size'=>'catalog_product_entity_varchar'),'size.entity_id = main_table.product_id AND size.attribute_id='.$PackageSize->getId(),array('size'=>'value'));
		
		
				   
		//bestellte Mengen ermitteln
		$exp = new Zend_Db_Expr('(select sum(qty) as quantity_ordered, product_id as pid, input_stock_id from extstock2_stock_journal where status = ' . Slpb_Extstock_Model_Journal::STATUS_ORDERED.' group by pid,input_stock_id )');		   
		//$exp = new Zend_Db_Expr('(select sum(qty) as quantity_ordered, product_id, input_stock_id from extstock2_stock_journal where status = 1 group by product_id,input_stock_id)');
		
		$collection->getSelect()
				   ->joinleft(array('ordered'=>$exp),'ordered.pid = main_table.product_id and ordered.input_stock_id=main_table.stock_id','quantity_ordered')		   
				   ;
		$this->setCollection($collection);
		
		
		
		
//die($this->getCollection()->getSelect()->__toString());		
		parent::_prepareCollection();
		//Mage::log(sprintf("slpb detail/collection grid:\n%s", $this->getCollection()->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		return $this;
	}

	protected function _prepareColumns()
	{
		/*
		$this->addColumn('id', array(
				'header'  => Mage::helper('extstock')->__('ID'),
				'align'   =>'right',
				'width'   => '30px',
				'type'	=> 'number',
				'index'   => 'product_id',
				'filter_index' => 'main_table.product_id'
		));
*/
		$this->addColumn('product', array(
				'header'  => Mage::helper('extstock')->__('Product'),
				//'align'   =>'right',
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

		$this->addColumn('qty', array(
				'header'  => Mage::helper('extstock')->__('Qty'),
				'align'   =>'right',
				'width'   => '50px',
				'type'	=> 'number',
				'index'   => 'qty',
				'filter_condition_callback' => array($this, '_filterQtyCondition'),
		));
			
		$this->addColumn('qty_total', array(
				'header'  => Mage::helper('extstock')->__('Total Qty'),
				'align'   =>'right',
				'width'   => '50px',
				'type'	=> 'number',
				'index'   => 'total_qty'
		));
		
		/*
		$options = Mage::getSingleton('eav/entity_attribute_source_boolean')->getOptionArray();
		$this->addColumn('limit_exceeded', array(
				'header'  => Mage::helper('extstock')->__('Limit exceeded'),
				'align'   =>'right',
				'width'   => '50px',
				'type'	  => 'options',
				'options' => $options,
				'show_missing_option_values' => true,
				'renderer' => 'extstock/adminhtml_warning_grid_renderer_options',
				'filter_condition_callback' => array($this, '_filterLimitExceededCondition'),
				'index'   => 'default_warning_qty'
		));
		*/
		$this->addColumn('quantity_ordered', array(
				'header'  => Mage::helper('extstock')->__('Outstanding Qty'),
				'align'   => 'right',
				'width'   => '50px',
				'type'	  => 'number',
				'index'   => 'quantity_ordered',
				//'filter_index' => 'size.value'
		));
		
		$this->addColumn('package_size', array(
				'header'  => Mage::helper('extstock')->__('Package Size'),
				'align'   => 'right',
				'width'   => '50px',
				'type'	  => 'number',
				'index'   => 'size',
				'filter_index' => 'size.value'
		));
		
	
		
		$this->addColumn('amount', array(
				'header'    	=> Mage::helper('extstock')->__('Requirements to move'),
				'name'      	=> 'amount_to_order',
				'width'     	=> '60px',
				'type'      	=> 'number',
				'validate_class' => 'validate-number',
 				'index'     	=> 'size',
				'index_qty'   	=> 'qty',
				'index_limit'   => 'default_order_qty',
				'editable'  => true,
				'default'	=> 0,
				'sortable'	=> false,
				'filter'    => false,
				'renderer' 	=> 'extstock/adminhtml_warning_grid_renderer_package'
//            'edit_only' => !$this->getSelectedFreecopyProducts()
		));

		$stock = Mage::getModel('extstock/stock');

		$this->addColumn('stock_id', array(
				'header'  => Mage::helper('extstock')->__('Stock'),
				'align'   =>'right',
				'width'   => '100px',
				'type'	=> 'options',
				'options' => $stock->getCollection()->asOptionsArray(),
				'is_for_commit' => true,
				'renderer' => 'extstock/adminhtml_warning_grid_renderer_options',
				'index'   => 'stock_id',
				'filter_index' => 'main_table.stock_id'
		));
	 
/*
		$acl = Mage::getSingleton('acl/productacl');
		 
		if ($acl->testPermission('admin/extstock/warning/extstockmove')) {
			$this->addColumn('action', array(
					'header'   => Mage::helper('extstock')->__('Action'),
					'filter'   => false,
					'sortable' => false,
					'width'    => '100',
					'renderer' => 'extstock/adminhtml_warning_grid_renderer_move'
			));
		}

		if ($acl->testPermission('admin/extstock/warning/extstockorder')) {
			$this->addColumn('action1', array(
					'header'   => Mage::helper('extstock')->__('Action'),
					'filter'   => false,
					'sortable' => false,
					'width'    => '100',
					'renderer' => 'extstock/adminhtml_warning_grid_renderer_order'
			));
		}
*/
		return parent::_prepareColumns();
	}
	
	protected function _filterLimitExceededCondition($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
	
		$collection->addWarningsFilter();
	}
	
	

	protected function _filterQtyCondition($collection, $column) {
		$filter = $column->getFilter()->getValue();
		$von = null;
		$bis = null;
		if (isset($filter['from'])) {
			$von = $filter['from']+0;
		}
		if (isset($filter['to'])) {
			$bis = $filter['to']+0;
		}


		if (($von !== null) && ($bis !== null)) {
			$this->getCollection()
				->getSelect()
				->having('sum(main_table.sum_qty) >= '.$filter['from'].' AND sum(main_table.sum_qty) <= '.$filter['to'] )
			;
		} elseif ($von !== null) {
			$this->getCollection()
				->getSelect()
				->having('sum(main_table.sum_qty) >= '.$filter['from'])
			;
		} elseif ($bis !== null) {
			$this->getCollection()
				->getSelect()
				->having('sum(main_table.sum_qty) <= '.$filter['to'] )
			;
		}
		return $this;
	}

	protected function _prepareMassaction() {
		$this->setChild('massaction',$this->getLayout()->createBlock('extstock/adminhtml_widget_grid_massaction','edtmassaction'));
		
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('product_id');
		$stock = Mage::getModel('extstock/stock');

		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		
		
		$this->getMassactionBlock()->addItem('movement', array(
				'label'    => Mage::helper('extstock')->__('Warnings Per Stock'),
				'url'      => $this->getUrl('adminhtml/extstock_warning/movement'),
				// 'complete' =>  "setLocation('".$this->getUrl('*/*/*')."');",
				'useajax'	=> true,
				//'onclick'	=> 'setLocation()'
				//'confirm'  => Mage::helper('stalaabo')->__('Are you sure?')
				'additional' => array(
						'visibility' => array(
								'name' => 'source',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('extstock')->__('Source'),
								'values' => $stock->getSourceStockAsOptionsArray()
						),
						'desired_date' => array(
								'name' => 'desired_date',
								'type' => 'date',
								'class' => 'required-entry',
								'label' => Mage::helper('extstock')->__('Desired Date'),
								'format'      => $dateFormatIso,
								'input_format' => $dateFormatIso,
								'image'  => $this->getSkinUrl('images/grid-cal.gif'),
								//'values' => $stock->getCollection()->asOptionsArray()
						),
						'note' => array(
								'name' => 'note',
								'type' => 'text',
								'label' => Mage::helper('extstock')->__('Note'),
						),
				),
		));

		return $this;
	}
	

	public function getCollection() {
		return parent::getCollection();
	}

	public function getThisUrl($action) {
		return 'adminhtml/extstock_warning/'.$action;
	}

	/**
	 * Wichtig für Ajax
	 */
	public function getGridUrl() {
		return $this->getUrl('adminhtml/extstock_warning/grid', array('_current'=>true));
	}

	//damit kann nicht auf die Zeile geklickt werden!
	//weil dort das popup nicht funktioniert
	public function getRowUrl($row) {

		//return "popWin('".$this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()))."', 'windth=800,height=700,resizable=1,scrollbars=1');return false;";

		//if($this->_isStockMode())
		{
			//return $this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()));
		}
		return "";
	}


}