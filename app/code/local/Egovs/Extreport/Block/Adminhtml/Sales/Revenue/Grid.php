<?php
/**
 * Adminhtml Report: Gewinn Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Revenue_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Initialisiert das Grid
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setId('revenueGrid');
		$this->setDefaultSort('created_at');
		$this->setDefaultDir('desc');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		$this->setVarNameFilter('customer_filter');
		$this->_controller = 'adminhtml_sales';

		$this->addExportType('*/*/exportRevenueCsv', 'CSV');
		$this->addExportType('*/*/exportRevenueExcel', 'XML (Excel)');
	}
	/**
	 * Liefert den Store zurück
	 *
	 * @return Mage_Core_Model_Store>
	 */
	protected function _getStore()
	{
		$storeId = (int) $this->getRequest()->getParam('store', 0);
		return Mage::app()->getStore($storeId);
	}
	/**
	 * Initialisiert die Collection
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Revenue_Grid
	 */
	protected function _prepareCollection()
	{
		$collection = Mage::getSingleton('extreport/sales_revenue')->getCollection();
		 
		if ($this->getRequest()->getParam('store')) {
			$storeIds = array($this->getParam('store'));
			$collection->addStoreFilter($storeIds[0]);
		} elseif ($this->getRequest()->getParam('website')) {
			$storeIds = Mage::app()->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
			$collection->addWebsiteFilter($storeIds);
		} elseif ($this->getRequest()->getParam('group')) {
			$storeIds = Mage::app()->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
			$collection->addWebsiteFilter($storeIds);
		} else {
			$storeIds = array('');
		}

		$this->setCollection($collection);

		parent::_prepareCollection();
		//$this->getCollection()->addWebsiteNamesToResult();
		return $this;
	}
	/**
	 * Fügt einen Splaten-Filter zur Collection hinzu
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Revenue_Grid
	 */
	protected function _addColumnFilterToCollection($column)
	{
		if ($this->getCollection()) {
			if ($column->getId() == 'websites') {
				$this->getCollection()->joinField('websites',
						'catalog/product_website',
						'website_id',
						'product_id=entity_id',
						null,
						'left');
			}
			if ($column->getId() == 'category') {
				$filter = $column->getFilter()->getValue();
				$this->getCollection()->setCategoryFilter($filter);
				return $this;
			}
			if ($column->getId() == 'price') {
				 
				$filter = $column->getFilter()->getValue();
				$select = $this->getCollection()->getSelect();
				if (isset($filter['from']))	$select->having('vk_sum >'.$filter['from']*1);
				if (isset($filter['to']))	$select->having('vk_sum <'.$filter['to']*1);
				//die($select->__toString());
				 
				 
				return $this;
			}
			if ($column->getId() == 'cost') {

				$filter = $column->getFilter()->getValue();
				$select = $this->getCollection()->getSelect();
				if (isset($filter['from']))	$select->having('ek_sum >='.$filter['from']*1);
				if (isset($filter['to']))	$select->having('ek_sum <='.$filter['to']*1);
				 
				return $this;
			}
			 
			if ($column->getId() == 'gewinn') {

				$filter = $column->getFilter()->getValue();
				$select = $this->getCollection()->getSelect();
				if (isset($filter['from']))	$select->having('(vk_sum - ek_sum) >='.$filter['from']*1);
				if (isset($filter['to']))	$select->having('(vk_sum - ek_sum) <='.$filter['to']*1);
				 
				return $this;
			}

			if ($column->getId() == 'qty') {

				$filter = $column->getFilter()->getValue();
				$select = $this->getCollection()->getSelect();
				if (isset($filter['from']))	$select->having('(sub_qty) >='.$filter['from']*1);
				if (isset($filter['to']))	$select->having('(sub_qty) <='.$filter['to']*1);
				 
				return $this;
			}
			if ($column->getId() == 'bestellstatus') {
				$filter = $column->getFilter()->getValue();
				$select = $this->getCollection()->getSelect();
				
				if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
					$select->where("order_state.value='".$filter."'");
				} else {
					$select->where("order.state = '".$filter."'");
				}

				return $this;
			}
		}
		//	die($this->getCollection()->getSelect()->__toString());
		return parent::_addColumnFilterToCollection($column);
	}
	/**
	 * Initialisiert die Spalten
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Revenue_Grid
	 */
	protected function _prepareColumns()
	{
		$this->addColumn('order_date',
				array(
						'header'=> Mage::helper('catalog')->__('Date'),
						'width' => '50px',
						'type'  => 'date',
						'index' => 'order_date',
						'filter_index' => 'order.created_at'
				));
		$this->addColumn('name',
				array(
						'header'=> Mage::helper('catalog')->__('Name'),
						'index' => 'name',
						'filter_index'=>'main_table.name',
				));
		/*
		 $store = $this->_getStore();
		if ($store->getId()) {
		$this->addColumn('custom_name',
				array(
						'header'=> Mage::helper('catalog')->__('Name In %s', $store->getName()),
						'index' => 'custom_name',
				));
		}

		*/
		$this->addColumn('sku',
				array(
						'header'=> Mage::helper('catalog')->__('SKU'),
						'width' => '80px',
						'index' => 'sku',
						'filter_index'=>'main_table.sku',
				));


		$this->addColumn('category',
				array(
						'header'=> Mage::helper('catalog')->__('Category'),
						'width' => '150px',
						'index' => 'category',
						'type'  => 'options',
						'renderer' => 'adminhtml/widget_grid_column_renderer_text',
						'options' => Mage::getSingleton('extreport/product_overview')->getCollection()->getCategorysAsOptionArray(),
						'filter_index' => 'category_ids',
				));

		$this->addColumn('qty',
				array(
						'header'=> Mage::helper('catalog')->__('Qty'),
						'width' => '100px',
						'type'  => 'number',
						'index' => 'sub_qty',
						'total' => 'sum',
				));

		$store = $this->_getStore();

		$this->addColumn('cost',
				array(
						'header'=> Mage::helper('catalog')->__('Cost'),
						'type'  => 'price',
						'currency_code' => $store->getBaseCurrency()->getCode(),
						'index' => 'ek_sum',
						'total' => 'sum',
						//'filter_index' => '(sum(extstock.price) * extorder.qty_ordered)'
				));

		$this->addColumn('price',
				array(
						'header'=> Mage::helper('extreport')->__('Revenue'),
						'type'  => 'price',
						'currency_code' => $store->getBaseCurrency()->getCode(),
						'index' => 'vk_sum',
						'total' => 'sum',
						 
				));

		 



		$this->addColumn('gewinn',
				array(
						'header'=> Mage::helper('extreport')->__('Yield'),
						'type'  => 'price',
						'currency_code' => $store->getBaseCurrency()->getCode(),
						'index' => 'yield',
						'total' => 'sum',
						 
				));


		$this->addColumn('bestellstatus',
				array(
						'header'=> Mage::helper('catalog')->__('Order Status'),
						'width' => '80px',
						'index' => 'bestellstatus',
						'type'  => 'options',
						//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
						'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
						//'filter_index' => 'order_state.value'
				));




		/*
		 if (!Mage::app()->isSingleStoreMode()) {
		$this->addColumn('websites',
				array(
						'header'=> Mage::helper('catalog')->__('Websites'),
						'width' => '100px',
						'sortable'  => false,
						'index'     => 'websites',
						'type'      => 'options',
						'options'   => Mage::getModel('core/website')->getCollection()->toOptionHash(),
				));
		}
		*/
		$this->setCountTotals(true);
		return parent::_prepareColumns();
	}

	/**
	 * Wird nach dem Laden der Colelction aufgerufen
	 * 
	 * @return void
	 */
	protected function _afterLoadCollection()
	{
		//die($this->getCollection()->getSelect()->__toString());
		$totalObj = new Mage_Reports_Model_Totals();
		$this->setTotals($totalObj->countTotals($this, 0, 0));
	}
	/**
	 * Liefert die Grid-URL
	 *
	 * @return string
	 */
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'revenue'));
	}
}
