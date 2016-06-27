<?php
/**
 * Adminhtml products by customer grid block
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Pbc_Grid extends Mage_Adminhtml_Block_Report_Grid
{

	protected $_defaultFilter = array(
            'report_from' => '',
            'report_to' => '',
            'report_period' => 'month'
        );
        
	public function __construct()
	{
		parent::__construct();
		 
		$this->setId('gridPbcSales');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		//Prefix der Namen der HTML Variablen
		$this->setVarNameFilter('pbc_filter');
		
		$this->setTemplate('egovs/extreport/grid.phtml');
		$this->setSubReportSize(0);	//nicht beschränkt!
		
		$this->addExportType('*/*/exportPbcCsv', Mage::helper('reports')->__('CSV'));
		$this->addExportType('*/*/exportPbcExcel', Mage::helper('reports')->__('XML (Excel)'));
	}

	protected function _getStore()
	{
		$storeId = (int) $this->getRequest()->getParam('store', 0);
		return Mage::app()->getStore($storeId);
	}
	
	protected function _prepareLayout()
    {
    	parent::_prepareLayout();
    	
        //Original store switcher entfernen
        $this->unsetChild('store_switcher');
        $this->setChild('store_switcher',
            $this->getLayout()->createBlock('extreport/store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($this->getUrl('*/*/*', array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml')
        );
        
        //cgroup kann auch 0 sein --> gibt sonst Probleme
        $cgroup = $this->getRequest()->getParam('cgroup');
    	if (isset($cgroup)) {
    		Mage::register('cgroup', $cgroup, true);    		
    	} else {
    		Mage::unregister('cgroup');
    	}
    	
    	$store = $this->getRequest()->getParam('store');
    	$website = $this->getRequest()->getParam('website');
    	$group = $this->getRequest()->getParam('group');
    	
    	if (isset($store)) {
            Mage::register('store', $store, true);
            Mage::unregister('website');
            Mage::unregister('group');
        } elseif (isset($website)) {
            Mage::register('website', $website, true);
            Mage::unregister('store');
            Mage::unregister('group');
        } elseif (isset($group)) {
            Mage::register('group', $group, true);
            Mage::unregister('website');
            Mage::unregister('store');
        } else {
        	Mage::unregister('store');
        	Mage::unregister('website');
            Mage::unregister('group');
        }
    	
        return $this;
    }
    
	protected function _prepareCollection()
	{
		parent::_prepareCollection();
		
		$this->getCollection()->initReport('extreport/sales_pbc_collection');
		
		$catfilter = $this->getFilter('reportfilter_category')+0;
		if ($catfilter > 0) {
			$this->getCollection()->setCategoryFilter($catfilter);
		}
		//$this->getCollection()->setCategoryFilter($filter);
        

		return $this;
	}

	protected function _prepareColumns()
	{
		$store = $this->_getStore();
		
		$this->addColumn('sku', array(
            'header'    =>Mage::helper('catalog')->__('SKU'),
            'index'     => 'sku',
        )); 
        
        $this->addColumn('name', array(
            'header'    => Mage::helper('sales')->__('Product Name'),
            'index'     => 'name',
        ));        
        
        $this->addColumn('names', array(
            'header' => Mage::helper('customer')->__('Name'),
            'index' => 'names',
            'renderer'  => 'extreport/widget_grid_column_renderer_concated'
        ));
        
        $this->addColumn('email', array(
        		'header' => Mage::helper('customer')->__('Email'),
        		'index' => 'email',
        		
        ));
        
        $this->addColumn('companyNames', array(
        		'header' => Mage::helper('customer')->__('Company Name'),
        		'index' => 'companyNames',
        		'renderer'  => 'extreport/widget_grid_column_renderer_concated'
        ));
		
        $this->addColumn('postAddress', array(
        		'header' => Mage::helper('customer')->__('Address'),
        		'index' => 'postAddress',
        		'renderer'  => 'extreport/widget_grid_column_renderer_concated'
        ));
        
        $this->addColumn('fullQty', array(
            'header'    => 	Mage::helper('sales')->__('Qty'),
            'index'     => 	'fullQty',
            'type'      => 	'number',
        	'total'     =>	'sum',
        ));
        
       	parent::_prepareColumns();
       
       	$this->setCountTotals(true);
       
       	return $this;
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'pbc'));
	}
	
	/**
	 * Liefert das Grid als Excel Xml
	 * 
	 * @param string $filename Dateiname
	 * 
	 * @return string
	 */
	public function getExcel($filename = '')
	{
		$this->_prepareGrid();
	
		$data = array();
		$row = array($this->__('Period'));
		foreach ($this->_columns as $column) {
			if (!$column->getIsSystem()) {
				$row[] = $column->getHeader();
			}
		}
		$data[] = $row;
	
		foreach ($this->getCollection()->getIntervals() as $_index=>$_item) {
			$report = $this->getReport($_item['start'], $_item['end']);
			foreach ($report as $_subIndex=>$_subItem) {
				$row = array($_index);
				foreach ($this->_columns as $column) {
					if (!$column->getIsSystem()) {
						$row[] = $column->getRowFieldExport($_subItem);
					}
				}
				$data[] = $row;
			}
			if ($this->getCountTotals() && $this->getSubtotalVisibility())
			{
				$row = array($_index);
				$j = 0;
				foreach ($this->_columns as $column) {
					$j++;
					if (!$column->getIsSystem()) {
						$row[] = ($j==1)?$this->__('Subtotal'):$column->getRowFieldExport($this->getTotals());
					}
				}
				$data[] = $row;
			}
		}
	
		if ($this->getCountTotals())
		{
			$row = array($this->__('Total'));
			foreach ($this->_columns as $column) {
				if (!$column->getIsSystem()) {
					$row[] = $column->getRowFieldExport($this->getGrandTotals());
				}
			}
			$data[] = $row;
		}
	
		$xmlObj = new Varien_Convert_Parser_Xml_Excel();
		$xmlObj->setVar('single_sheet', $filename);
		$xmlObj->setData($data);
		$xmlObj->unparse();
	
		//Content mit UTF-8 BOM
		return chr(239).chr(187).chr(191).$xmlObj->getData();
	}
}
