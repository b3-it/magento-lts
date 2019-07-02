<?php

class Slpb_Extstock_Block_Adminhtml_Extstocklist_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_product = null;
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockGridList');
		$this->setDefaultSort('name');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		if(isset( $attributes['product']))
			$this->_product = $attributes['product'];		 
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('extstock/extstocklist_collection');

		$this->setCollection($collection);

		if($this->_product != null)
		{
			$id = $this->_product->getEntityId();
			if($id == null) $id = -1;
			
			$collection->getSelect()->where("product_id = ?", intval($id));
		}
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$store = Mage::app()->getStore();
		if($this->_isStockMode())
		{
			$this->addColumn('name', array(
	          'header'    => Mage::helper('extstock')->__('Product'),
	          'align'     =>'left',
	          'index'     => 'name',
			));
			
			$this->addColumn('sku', array(
	          'header'    => Mage::helper('extstock')->__('sku'),
	          'align'     =>'left',
	     	  'width'     => '50px',	
	          'index'     => 'sku',
			));
		}

		$this->addColumn('total_quantity', array(
          'header'    => Mage::helper('extstock')->__('Avail Qty'),
          'align'     =>'right',
      	  'width'     => '40px',	
          'index'     => 'total_quantity',
		  'type'	=> 'number',
		));
		
		$this->addColumn('cost_price', array(
          'header'    => Mage::helper('extstock')->__('From Cost Price/Article'),
      	  'type'  => 'price',
          'currency_code' => $store->getBaseCurrency()->getCode(),
          'align'     =>'right',
      	  'width'     => '40px',	
          'index'     => 'cost_price'
		));
		
		$this->addColumn('stock_value', array(
          'header'    => Mage::helper('extstock')->__('Stock Value'),
          'align'     =>'right',
      	  'width'     => '40px',	
          'index'     => 'stock_value',
		  'type'	  => 'price',
		  'currency_code' => $store->getBaseCurrencyCode(),	
		));

		
		$this->addColumn('distributor', array(
          'header'    => Mage::helper('extstock')->__('Distributor'),
          'align'     =>'left',
      	  'width'     => '100px',	
          'index'     => 'distributor',
		));		
		
		$this->addColumn('storage', array(
          'header'    => Mage::helper('extstock')->__('Storage'),
          'align'     =>'left',
      	  'width'     => '50px',	
          'index'     => 'storage',
		));

		$this->addColumn('rack', array(
          'header'    => Mage::helper('extstock')->__('Rack'),
          'align'     =>'left',
      	  'width'     => '50px',	
          'index'     => 'rack',
		));
		 
		if($this->_isStockMode())
		{
			$this->addExportType('*/*/exportCsv', Mage::helper('extstock')->__('CSV'));
			//$this->addExportType('*/*/exportXml', Mage::helper('extstock')->__('XML'));
		}
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{

		return $this;
	}

	public function getThisUrl($action)
	{
		return 'adminhtml/extstock_extstocklist/'.$action;
	}
	
	/**
	 * Wichtig für Ajax
	 */ 
	public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

	public function getRowUrl($row)
	{
		return $this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()));
	}

	/**
	 * Feststellen ob das Grid von der Lagerverwaltung oder Produktverwaltung
	 * aufgerufen wurde
	 * @return boolean
	 */
	private function _isStockMode()
	{
		if($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode'))
		{
			if($mode == 'product') return false;
		}
		return true;
	}
}