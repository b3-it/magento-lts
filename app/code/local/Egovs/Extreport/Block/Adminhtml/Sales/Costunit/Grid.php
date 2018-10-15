<?php
/**
 * Adminhtml Report: Kostenträger - Kostenstelle
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Costunit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_hhParameter = null;

	/**
	 * Initialisiert das Grid
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setId('costunitGrid');
		$this->setDefaultSort('order_date');
		$this->setDefaultDir('desc');
		//Die letzten 30 Tage anzeigen 
		$fromDate = Mage::getModel('core/date')->timestamp(time() - (3600 * 24 * 30));
		$fromDate = Mage::app()->getLocale()->date($fromDate);
		$now = Mage::app()->getLocale()->date();
		$this->setDefaultFilter(
				array('order_date' => array('from' => $fromDate, 'to' => $now))
		);
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		$this->setVarNameFilter('customer_filter');
		$this->_controller = 'adminhtml_sales';

		$this->addExportType('*/*/exportCostunitCsv', 'CSV');
		$this->addExportType('*/*/exportCostunitExcel', 'XML (Excel)');
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
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Costunit_Grid
	 */
	protected function _prepareCollection()
	{
		$collection = Mage::getSingleton('extreport/sales_costunit')->getCollection();
		 
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

        $compositeTypeIds     = Mage::getSingleton('catalog/product_type')->getCompositeTypes();
        $collection->getSelect()->where("main_table.product_type NOT IN (?)",$compositeTypeIds);

		$this->setCollection($collection);

		//die($collection->getSelect()->__toString());
		parent::_prepareCollection();
		//$this->getCollection()->addWebsiteNamesToResult();
		return $this;
	}
	/**
	 * Fügt einen Splaten-Filter zur Collection hinzu
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Costunit_Grid
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
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Costunit_Grid
	 */
	protected function _prepareColumns()
	{
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$this->addColumn('order_date',
				array(
						'header'=> Mage::helper('catalog')->__('Date'),
						'width' => '50px',
						'type'  => 'date',
						'format' => $dateFormatIso,
						'index' => 'order_date',
						'filter_index' => 'order.created_at'
				));
		$this->addColumn('name',
				array(
						'header'=> Mage::helper('catalog')->__('Name'),
						'index' => 'name',
						'filter_index'=>'main_table.name',
				));
		
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
						'index' => 'qty_ordered',
						'filter_index' => 'main_table.qty_ordered',
						'total' => 'sum',
				));

		$store = $this->_getStore();

		/* $this->addColumn('cost',
				array(
						'header'=> Mage::helper('catalog')->__('Cost'),
						'type'  => 'price',
						'currency_code' => $store->getBaseCurrency()->getCode(),
						'index' => 'ek_sum',
						'total' => 'sum',
						//'filter_index' => '(sum(extstock.price) * extorder.qty_ordered)'
				)); */
		//Default
		$_priceOptions = array(
						'header'=> Mage::helper('extreport')->__('Sales Total'),
						'type'  => 'price',
						'currency_code' => $store->getBaseCurrency()->getCode(),
						'index' => 'base_row_total',
						'filter_index' => 'main_table.base_row_total',
						'total' => 'sum',
						 
		);
		if (Mage::getStoreConfig('reports/costunit/tax_sales_display_price', $this->_getStore()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX) {
			$_priceOptions['index'] = 'base_row_total_incl_tax';
			$_priceOptions['filter_index'] = 'main_table.base_row_total_incl_tax';
		} elseif (Mage::getStoreConfig('reports/costunit/tax_sales_display_price', $this->_getStore()) == Mage_Tax_Model_Config::DISPLAY_TYPE_EXCLUDING_TAX) {
			$_priceOptions['index'] = 'base_row_total';
			$_priceOptions['filter_index'] = 'main_table.base_row_total';
		}
		
		$this->addColumn('price', $_priceOptions);
		/* @var $catalog Mage_Catalog_Model_Resource_Product */
		$catalog = Mage::getResourceSingleton('catalog/product');
		$kostenstelle = $catalog->getAttribute('kostenstelle');
		if ($kostenstelle) {
			$this->addColumn('costunit',
					array(
							'header'=> Mage::helper('extreport')->__('Cost unit'),
							'index' => 'kostenstelle',
							'filter_index' => sprintf('_left_%s.value', $kostenstelle->getAttributeCode()),


					)
			);
		}
		
		$kostentraeger = $catalog->getAttribute('kostentraeger');
		if ($kostentraeger) {
			$this->addColumn('costobject',
					array(
							'header'=> Mage::helper('extreport')->__('Cost object'),
							'index' => 'kostentraeger',
							'filter_index' => sprintf('_left_%s.value', $kostentraeger->getAttributeCode()),

					)
			);
		}
		
		$this->addColumn('haushaltsstelle',
				array(
						'header'=> Mage::helper('extreport')->__('Haushaltsstelle'),
						'index' => 'haushaltsstelle',
						'filter_index' => sprintf('_left_%s.value', $catalog->getAttribute('haushaltsstelle')->getAttributeCode()),
                    'type'  => 'options',
                    'options' => $this->_getHHParamOptions(Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE),
				)
		);
		
		$this->addColumn('objnumber',
				array(
						'header'=> Mage::helper('extreport')->__('Object number'),
						'index' => 'objektnummer',
						'filter_index' => sprintf('_left_%s.value', $catalog->getAttribute('objektnummer')->getAttributeCode()),
                    'type'  => 'options',
                    'options' => $this->_getHHParamOptions(Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER),
				)
		);
		
		$this->addColumn('objnumbermwst',
				array(
						'header'=> Mage::helper('extreport')->__('Object number VAT'),
						'index' => 'objektnummer_mwst',
						'filter_index' => sprintf('_left_%s.value', $catalog->getAttribute('objektnummer_mwst')->getAttributeCode()),
                    'type'  => 'options',
                    'options' => $this->_getHHParamOptions(Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST),
				)
		);

		if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
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
		} else {
			$this->addColumn('bestellstatus',
					array(
							'header'=> Mage::helper('catalog')->__('Order Status'),
							'width' => '80px',
							'index' => 'state',
							'type'  => 'options',
							//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
							'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
							//'filter_index' => 'order_state.value'
					));
		}

        $this->addColumn('payment_method', array(
            'header'    => Mage::helper('sales')->__('Payment Method'),
            'index'     => 'method',
            'type'      => 'options',
            'width'     => '130px',
            'options'   => Mage::helper('paymentbase')->getActivePaymentMethods(),
        ));
		
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
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'costunit'));
	}

	protected function _getHHParamOptions($type)
    {
        $res = array();
        if($this->_hhParameter == null){
            $this->_hhParameter = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
        }

        foreach( $this->_hhParameter as $hh)
        {
            if($hh->getType() == $type){
                $res[$hh->getId()] = $hh->getTitle();
            }
        }

        return $res;
    }
}
