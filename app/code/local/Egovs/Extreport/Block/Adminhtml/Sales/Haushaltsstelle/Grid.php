<?php

/**
 * Adminhtml Report: Produktüberblick Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Haushaltsstelle_Grid extends Egovs_Extreport_Block_Adminhtml_AbstractReportGrid
{
	protected $_defaultFilter = array(
			'report_from' => '',
			'report_to' => '',
			'report_period' => 'month'
	);
	
	protected $_baseActionName = 'haushaltsstelle';

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
			
		$this->setId('gridHaushaltsstelleSales');
		//Prefix der Namen der HTML Variablen
		$this->setVarNameFilter('haushaltsstelle_filter');

		$this->setSubReportSize(0);	//nicht beschränkt!

		$this->setTemplate('egovs/extreport/grid.phtml');
		
		$this->addExportType('*/*/exportHaushaltsstelleCsv', Mage::helper('reports')->__('CSV'));
		$this->addExportType('*/*/exportHaushaltsstelleExcel', Mage::helper('reports')->__('XML (Excel)'));
	}

	/**
	 * Fügt einen Splaten-Filter zur Collection hinzu
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Haushaltsstelle_Grid
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
		}

		return parent::_addColumnFilterToCollection($column);
	}

	/**
	 * Liefert die Haushaltsstellen als Option-Array
	 * 
	 * @return array
	 * 
	 * @see Egovs_Extreport_Helper_Data::getHaushaltsstelleAsOptionArray
	 */
	public function getHaushaltsstelleFilter()
	{
		return $this->helper('extreport')->getHaushaltsstelleAsOptionArray();
	}
	/**
	 * Initialisiert die Collection
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Haushaltsstelle_Grid
	 */
	protected function _prepareCollection()
	{
		parent::_prepareCollection();

		$this->getCollection()->initReport('extreport/sales_haushaltsstelle_collection');

		$filter = $this->getFilter('reportfilter_haushaltsstelle');
		if (strlen($filter) > 0) {
			$this->getCollection()->setHaushaltsstelleFilter($filter);
		}
		//$this->getCollection()->setCategoryFilter($filter);

       	return $this;
	}
	/**
	 * Initialisiert die Spalten
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Haushaltsstelle_Grid
	 */
	protected function _prepareColumns()
	{
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

		$opt = $this->helper('extreport')->getHaushaltsstelleAsOptionArray();
		//$opt= array();
		//foreach($tmp as $key => $value){
			//$opt[] = array('label' => $value,'value'=>$key);
		//}
		$this->addColumn('haushaltsstelle',
				array(
						'header'=> Mage::helper('catalog')->__('Haushaltsstelle'),
						'width' => '150px',
						'index' => 'haushaltsstelle',
						'type'  => 'options',
						//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
						'options' => $opt,
						//'filter_index' => 'haushaltsstelle'
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

		$this->addColumn('total_shipped',
				array(
						'header'=> Mage::helper('catalog')->__('Qty'),
						'width' => '100px',
						'type'  => 'number',
						'index' => 'total_shipped',
						'total' => 'sum',
				));

		$this->setCountTotals(true);

		return parent::_prepareColumns();
	}
}