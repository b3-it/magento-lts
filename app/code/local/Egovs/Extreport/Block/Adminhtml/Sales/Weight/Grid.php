<?php

/**
 * Adminhtml Report: Gewicht von Sendungen Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Weight_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Initialisiert das Grid
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setId('weightGrid');
		$this->setDefaultSort('created_at');
		$this->setDefaultDir('desc');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		$this->setVarNameFilter('weight_filter');
		$this->_controller = 'adminhtml_sales';

		$this->addExportType('*/*/exportWeightCsv', 'CSV');
		$this->addExportType('*/*/exportWeightExcel', 'XML (Excel)');
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
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Weight_Grid
	 */
	protected function _prepareCollection()
	{
		$collection = Mage::getSingleton('extreport/sales_weight')->getCollection();
		 
		$collection->addWeight();
		 
		 
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
		//die($this->getCollection()->getSelect()->__toString());
		parent::_prepareCollection();
		//$this->getCollection()->addWebsiteNamesToResult();
		return $this;
	}
	/**
	 * Fügt einen Splaten-Filter zur Collection hinzu
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Weight_Grid
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
			
			if ($column->getId() == 'bestellstatus' && version_compare(Mage::getVersion(), '1.4.1', '<')) {
				$filter = $column->getFilter()->getValue();
				$this->getCollection()
					->getSelect()
					->where("order_state.value='".$filter."'");
				
				Mage::log(sprintf('sql: %s', $this->getCollection()->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				return $this;
			}
		}
		//	die($this->getCollection()->getSelect()->__toString());
		return parent::_addColumnFilterToCollection($column);
	}
	/**
	 * Initialisiert die Spalten
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Weight_Grid
	 */
	protected function _prepareColumns()
	{
		$this->addColumn('id',
				array(
						'header'=> Mage::helper('catalog')->__('ID'),
						//'width' => '50px',
						'type'  => 'number',
						'index' => 'entity_id',

				));
		
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$this->addColumn('order_date',
				array(
						'header'=> Mage::helper('catalog')->__('Date'),
						'width' => '50px',
						'type'  => 'date',
						'format' => $dateFormatIso,
						'index' => 'created_at',
						//'filter_index' => 'order.created_at'
				));

		$this->addColumn('incid',
				array(
						'header'=> Mage::helper('catalog')->__('Bestellnummer'),
						//'width' => '50px',
						'type'  => 'number',
						'index' => 'increment_id',

				));

		$this->addColumn('weight',
				array(
						'header'=> Mage::helper('extreport')->__('Weight'),
						'width' => '50px',
						'type'  => 'number',
						'index' => 'weight',
						'filter_index' => version_compare(Mage::getVersion(), '1.4.1', '<') ? 'weight' : 't1.weight',
				));

		$this->addColumn('bestellstatus',
				array(
						'header'=> Mage::helper('catalog')->__('Order Status'),
						'width' => '80px',
						'index' => 'bestellstatus',
						'type'  => 'options',
						//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
						'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
						'filter_index' => version_compare(Mage::getVersion(), '1.4.1', '<') ? 'order_state.value' : 'state',
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
		//$this->setCountTotals(true);
		return parent::_prepareColumns();
	}	 
	/**
	 * Liefert die Grid-URL
	 *
	 * @return string
	 */
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'weight'));
	}
}