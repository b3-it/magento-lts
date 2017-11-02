<?php
/**
 * Adminhtml Report: Produktüberblick Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Product_Overview_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Initialisiert das Grid
	 *
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('product_filter');
        $this->addExportType('*/*/exportOverviewsCsv', 'CSV');
        $this->addExportType('*/*/exportOverviewsExcel', 'XML (Excel)');
		$this->_controller = 'adminhtml_product';
		
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
     * @return Egovs_Extreport_Block_Adminhtml_Product_Overview_Grid
     */
    protected function _prepareCollection()
    {    	
        $store = $this->_getStore();
        $collection = Mage::getSingleton('extreport/product_overview')->getCollection();    
            
        //var_dump($storeIds);   
  
        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            //var_dump($store->getId());
            //$collection->addStoreFilter($store);
            $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
        } else {
            $collection->addAttributeToSelect('price');
            $collection->addAttributeToSelect('status');
            $collection->addAttributeToSelect('visibility');
        }
        
        $this->setCollection($collection);

        parent::_prepareCollection();
       
        return $this;
    }
    /**
     * Fügt einen Splaten-Filter zur Collection hinzu
     *
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Overview_Grid
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
     * Initialisiert die Spalten
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Overview_Grid
     */
    protected function _prepareColumns()
    {
    	if (Mage::getStoreConfig('reports/productoverview/id') == 1) {
    		$this->addColumn('entity_id',
    				array(
    						'header'=> Mage::helper('catalog')->__('ID'),
    						'width' => '50px',
    						'type'  => 'number',
    						'index' => 'entity_id',
    						//'total' => 'Total',
    				));
    	}
    	if (Mage::getStoreConfig('reports/productoverview/name') == 1) {
    		$this->addColumn('name',
    				array(
    						'header'=> Mage::helper('catalog')->__('Name'),
    						'index' => 'name',
    				));
    	}
    	$store = $this->_getStore();
    	if (Mage::getStoreConfig('reports/productoverview/custom_name') == 1) {
    		if ($store->getId()) {
    			$this->addColumn('custom_name',
    					array(
    							'header'=> Mage::helper('catalog')->__('Name In %s', $store->getName()),
    							'index' => 'custom_name',
    					));
    		}
    	}
    	if (Mage::getStoreConfig('reports/productoverview/sku') == 1) {
    		$this->addColumn('sku',
    				array(
    						'header'=> Mage::helper('catalog')->__('SKU'),
    						'width' => '80px',
    						'index' => 'sku',
    				));
    	}
    	if (Mage::getStoreConfig('reports/productoverview/type') == 1) {
    		$this->addColumn('type',
    				array(
    						'header'=> Mage::helper('catalog')->__('Type'),
    						'width' => '150px',
    						'index' => 'type_id',
    						'type'  => 'options',
    						'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
    				));
    	}
    	 
    	if (Mage::getStoreConfig('reports/productoverview/category') == 1) {
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
    	}
    	 
    	$store = $this->_getStore();
    	if (Mage::getStoreConfig('reports/productoverview/price') == 1) {
    		$this->addColumn('price',
    				array(
    						'header'=> Mage::helper('catalog')->__('Price'),
    						'type'  => 'price',
    						'currency_code' => $store->getBaseCurrency()->getCode(),
    						'index' => 'price',
    						'total' => 'sum',
    				));
    	}

    	if (Mage::getStoreConfig('reports/productoverview/taxclass') == 1) {
    		$this->addColumn('taxclass',
    				array(
    						'header'=> Mage::helper('catalog')->__('Tax Class'),
    						'type'  => 'options',
    						'width' => '100px',
    						//'currency_code' => $store->getBaseCurrency()->getCode(),
    						'index' => 'tax_class_id',
    						'options' => $this->_getTaxClassToOptionarray(),
    				));
    	}
    	 
    	if (Mage::getStoreConfig('reports/productoverview/weight') == 1) {
    		$this->addColumn('weight',
    				array(
    						'header'=> Mage::helper('catalog')->__('Weight'),
    						'width' => '100px',
    						'type'  => 'number',
    						'index' => 'weight',
    						'total' => 'sum',
    				));
    	}
    	 
    	if (Mage::getStoreConfig('reports/productoverview/qty') == 1) {
    		$this->addColumn('qty',
    				array(
    						'header'=> Mage::helper('catalog')->__('Qty'),
    						'width' => '100px',
    						'type'  => 'number',
    						'index' => 'qty',
    						'total' => 'sum',
    				));
    	}
    	if (Mage::getStoreConfig('reports/productoverview/visibility') == 1) {
    		$this->addColumn('visibility',
    				array(
    						'header'=> Mage::helper('catalog')->__('Visibility'),
    						'width' => '70px',
    						'index' => 'visibility',
    						'type'  => 'options',
    						'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
    				));
    	}

    	if (Mage::getStoreConfig('reports/productoverview/status') == 1) {
    		$this->addColumn('status',
    				array(
    						'header'=> Mage::helper('catalog')->__('Status'),
    						'width' => '70px',
    						'index' => 'status',
    						'type'  => 'options',
    						'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
    				));
    	}

    	if (Mage::getStoreConfig('reports/productoverview/availability') == 1) {
    		$this->addColumn('is_in_stock',
    				array(
    						'header'=> Mage::helper('catalog')->__('Availability'),
    						'width' => '90px',
    						'index' => 'is_in_stock',
    						'type'  => 'options',
    						'options' => array('1'=>Mage::helper('cataloginventory')->__('In stock'),'0'=>Mage::helper('cataloginventory')->__('Not in stock')),
    				));
    	}

    	$this->setCountTotals(true);
    	return parent::_prepareColumns();
    }

    /**
     * Wird nach dem Laden der Collection aufgerufen
     * 
     * @return void
     */
    protected function _afterLoadCollection()
    {
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
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'overview'));
	}
	/**
	 * Liefert ein Option-Array von Steuerklassen
	 * 
	 * @return array
	 */
	protected function _getTaxClassToOptionarray()
	{
		$items = Mage::getModel('tax/class_source_product')->getAllOptions();
		$res = array();
		foreach ($items as $item) {
			$res[$item['value']] = $item['label'];
		}
		return $res;
	}
}
