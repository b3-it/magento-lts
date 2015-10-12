<?php

class Slpb_Extstock_Block_Adminhtml_Detail_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


	
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockDetailGrid');
		//$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

  
	

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('extstock/detail_collection');
		$this->setCollection($collection);
		//die($collection->getSelect()->__toString());	
		return parent::_prepareCollection();	
		
	}
	
	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
	          'header'  => Mage::helper('extstock')->__('ID'),
	          'align'   =>'right',
	          'width'   => '30px',
			  'type'	=> 'number',
	          'index'   => 'product_id',
			  
			));
		
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
			  'filter_index'=>'sum(main_table.sum_qty)'
			));
		

		
		$stock = Mage::getModel('extstock/stock');	
		
		$this->addColumn('stock_id', array(
	          'header'  => Mage::helper('extstock')->__('Stock'),
	          'align'   =>'right',
	          'width'   => '100px',
			  'type'	=> 'options',
			  'options' => $stock->getCollection()->asOptionsArray(),
	          'index'   => 'stock_id',
		'filter_index' => 'main_table.stock_id'
			  
			));

		$this->addExportType('*/*/exportCsv', Mage::helper('extstock')->__('CSV'));	

		return parent::_prepareColumns();
	}

  	protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
           if ($column->getId() == 'qty') {
           		$filter = $column->getFilter()->getValue();
           		$von = null;
           		$bis = null;
           		if(isset($filter['from'])){ $von = $filter['from']+0;}
           		if(isset($filter['to'])){ $bis = $filter['to']+0;}
           		
           		
           		if(($von !== null) && ($bis !== null))
           		{
	           		$this->getCollection()
	           			->getSelect()
	           			->having('sum(main_table.sum_qty) >= '.$filter['from'].' AND sum(main_table.sum_qty) <= '.$filter['to'] );
	           	}
                elseif($von !== null)
           		{
	           		$this->getCollection()
	           			->getSelect()
	           			->having('sum(main_table.sum_qty) >= '.$filter['from']);
	           	}
                elseif($bis !== null)
           		{
	           		$this->getCollection()
	           			->getSelect()
	           			->having('sum(main_table.sum_qty) <= '.$filter['to'] );
	           	}
                return $this;
           }
        }
        return parent::_addColumnFilterToCollection($column);
    }
	
	
	protected function _prepareMassaction()
	{

		return $this;
	}

	public function getThisUrl($action)
	{
		return 'extstock/adminhtml_detail/'.$action;
	}
	
	/**
	 * Wichtig für Ajax
	 */ 
	public function getGridUrl()
    {
        return $this->getUrl('adminhtml/extstock_detail/grid', array('_current'=>true));
    }

    //damit kann nicht auf die Zeile geklickt werden!
    //weil dort das popup nicht funktioniert
	public function getRowUrl($row)
	{
				return "";
	}


}