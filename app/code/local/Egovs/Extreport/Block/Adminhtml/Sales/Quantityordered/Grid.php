<?php

/**
 * Adminhtml total visitors
 *
 * @category   Egovs
 * @package    Egovs_Extreport
 * @author 	   Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license	   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Quantityordered_Grid extends Egovs_Extreport_Block_Adminhtml_AbstractReportGrid
{
	protected $_defaultFilter = array(
			'report_from' => '',
			'report_to' => '',
			'report_period' => 'month'
	);
	
	protected $_baseActionName = 'quantityordered';
	
	/**
	 * Initialisiert das Grid
	 *
	 * Setzt eigenes Template
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
			
		$this->setId('gridQuantitySales');
		//Prefix der Namen der HTML Variablen
		$this->setVarNameFilter('quantity_filter');

		$this->setSubReportSize(0);	//nicht beschränkt!

		$this->setTemplate('egovs/extreport/grid.phtml');
		
		$this->addExportType('*/*/exportQuantityCsv', Mage::helper('reports')->__('CSV'));
		$this->addExportType('*/*/exportQuantityExcel', Mage::helper('reports')->__('XML (Excel)'));
	}

	/**
	 * Fügt einen Spaltenfilter hinzu
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Instanz der Spalte
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Quantityordered_Grid
	 *
	 * @see Mage_Adminhtml_Block_Widget_Grid::_addColumnFilterToCollection()
	 */
	protected function _addColumnFilterToCollection($column) {
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
		}

		return parent::_addColumnFilterToCollection($column);
	}

	/**
	 * Gibt die Kategorien als Option-Array zurück
	 *
	 * @return array
	 */
	public function getCategoryFilter() {
		return Mage::getSingleton('extreport/product_overview')->getCollection()->getCategorysAsOptionArray();
	}

	/**
	 * Bereitet die Collection für das Laden vor
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Quantityordered_Grid
	 *
	 * @see Mage_Adminhtml_Block_Report_Grid::_prepareCollection()
	 */
	protected function _prepareCollection() {
		parent::_prepareCollection();

		$this->getCollection()->initReport('extreport/sales_quantity_collection');

		$catfilter = $this->getFilter('reportfilter_category')+0;
		if ($catfilter > 0) {
			$this->getCollection()->setCategoryFilter($catfilter);
		}
		
		return $this;
	}

	/**
	 * Erstellt die entsprechenden Spalten im Grid
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Quantityordered_Grid
	 */
	protected function _prepareColumns() {
		$store = $this->_getStore();
			
		$this->addColumn('name',
				array(
						'header'=> Mage::helper('catalog')->__('Name'),
						'index' => 'name',
				));

		if ($store->getId()) {
			$this->addColumn('custom_name',
					array(
							'header'=> Mage::helper('catalog')->__('Name In %s', $store->getName()),
							'index' => 'custom_name',
					));
		}

		 
		$this->addColumn('sku',
				array(
						'header'=> Mage::helper('catalog')->__('SKU'),
						'width' => '80px',
						'index' => 'sku',
				));

		$this->addColumn('category',
				array(
						'header'=> Mage::helper('catalog')->__('Category'),
						'width' => '150px',
						'index' => 'category',
						'type'  => 'options',
						'renderer' => 'adminhtml/widget_grid_column_renderer_text',
						'options' => Mage::getSingleton('extreport/sales_revenue')->getCollection()->getCategorysAsOptionArray(),
						'filter_index' => 'sku'
				));

		$this->addColumn('total_ordered',
				array(
						'header'=> Mage::helper('catalog')->__('Qty Ordered'),
						'width' => '100px',
						'type'  => 'number',
						'index' => 'total_ordered',
						'total' => 'sum',
				));

		$this->addColumn('total_shipped',
				array(
						'header'=> Mage::helper('catalog')->__('Qty Shipped'),
						'width' => '100px',
						'type'  => 'number',
						'index' => 'total_shipped',
						'total' => 'sum',
				));

		$this->addColumn('total_price',
				array(
						'header'=> Mage::helper('extreport')->__('Total Order Value').' [netto]',
						'width' => '100px',
						'type'  => 'price',
						'currency_code' => $store->getBaseCurrencyCode(),
						'index' => 'total_price',
						'total' => 'sum',
				));

		$this->setCountTotals(true);

		return parent::_prepareColumns();
	}
}