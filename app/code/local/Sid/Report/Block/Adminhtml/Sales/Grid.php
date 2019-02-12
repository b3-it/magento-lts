<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales report grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Report_Block_Adminhtml_Sales_Grid extends Sid_Report_Block_Adminhtml_AbstractReportGrid
{
    protected $_columnGroupBy = 'period';

    public function __construct()
    {
        parent::__construct();
        //$this->setTemplate('widget/grid.phtml');
        $this->setDateFilterVisibility(false);
        $this->setStoreSwitcherVisibility(false);
        $this->setCountTotals(true);
        $this->setCountSubTotals(true);
        $this->setExportVisibility(true);
    }
    
    public function getResourceCollectionName()
    {
    	return 'sidreport/sales_collection';
    }

    protected function _prepareCollection()
    {
        $filterData = $this->getFilterData();
        //die PageSize setzen da sonst nur ein Teil angezeigt wird (LIMIT 5) ZV_FM-1157
        $this->setSubReportSize(false);
        parent::_prepareCollection();
 
        $this->getCollection()->initReport('sidreport/sales_collection');
	    $this->getCollection()->setPeriod($this->getFilter('period_type'));
	    $this->getCollection()->getReportModel()->setLos($this->getFilter('los'));
	    $this->getCollection()->getReportModel()->setCustomerGroup($this->getFilter('customer_group'));
	    $this->getCollection()->getReportModel()->setDienststelle($this->getFilter('dienststelle'));
	    $this->getCollection()->setInterval($this->getFilter('from'),$this->getFilter('to'));
//die( $this->getCollection()->getReportModel()->getSelect()->__toString());	 
	  
        return $this;
    }
    
 
    
    protected function _prepareColumns()
    {

    
    	
        $this->addColumn('product_name', array(
            'header'    => Mage::helper('sales')->__('Product Name'),
            'index'     => 'name',
            'type'      => 'string',
            'sortable'  => false
        ));
        
       $this->addColumn('sku', array(
            'header'    => Mage::helper('sales')->__('SKU'),
            'index'     => 'sku',
            'type'      => 'string',
            'sortable'  => false
        ));

        if ($this->getFilterData()->getStoreIds()) {
            $this->setStoreIds(explode(',', $this->getFilterData()->getStoreIds()));
        }
        
        $currencyCode = $this->getCurrentCurrencyCode();

        
        $this->addColumn('total_price_base_row_total', array(
        		'header'        => Mage::helper('sales')->__('Gesamtpreis Netto'),
        		'type'          => 'currency',
        		'currency_code' => $currencyCode,
        		'index'         => 'total_price_base_row_total',
        		'total'     	=> 'sum',
        		'sortable'      => false
        ));
        
        $this->addColumn('total_price_base_row_total_incl_tax', array(
            'header'        => Mage::helper('sales')->__('Gesamtpreis Brutto'),
            'type'          => 'currency',
            'currency_code' => $currencyCode,
            'index'         => 'total_price_base_row_total_incl_tax',
        	'total'     	=> 'sum',
            'sortable'      => false
        ));
        
       

        $this->addColumn('total_qty', array(
            'header'    => Mage::helper('sales')->__('Quantity Ordered'),
            'index'     => 'total_qty',
            'type'      => 'number',
            'total'     => 'sum',
            'sortable'  => false
        ));

        $this->addColumn('all_dst', array(
            'header'    => Mage::helper('sales')->__('Dienststelle'),
            'index'     => 'all_dst',
            'type'      => 'string',
            'sortable'  => false
        ));
        
        $this->addColumn('name', array(
        		'header'    => Mage::helper('sales')->__('Name'),
        		'index'     => 'billing_name',
        		'type'      => 'string',
        		'sortable'  => false
        ));
        
        $this->addColumn('company', array(
        		'header'    => Mage::helper('sales')->__('Company'),
        		'index'     => 'billing_company',
        		'type'      => 'string',
        		'sortable'  => false
        ));
        
       
        
        $this->addColumn('los', array(
        		'header'    => Mage::helper('framecontract')->__('Los'),
        		'align'     => 'left',
        		//'width'     => '150px',
        		'index'     => 'contractlos',
        		'type'      => 'string',
        		
        ));
        
		$this->setCountTotals(true);

        $this->addExportType('*/*/exportSalesCsv', Mage::helper('adminhtml')->__('CSV'));
        $this->addExportType('*/*/exportSalesExcel', Mage::helper('adminhtml')->__('Excel XML'));

        
        return parent::_prepareColumns();
    }
    
    protected function _afterToHtml($html)
    {
    	$s = $this->getCollection()->getReportModel()->getSelect()->__toString();
    	$this->setLog($s);
    	return parent::_afterToHtml($html);
    }
 
}
