<?php

/**
 * Verkäufe-Report-Controller
 * 
 * Behandelt die Reports im Menü Verkäufe
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Adminhtml_Extreport_SalesController extends Egovs_Extreport_Controller_Abstract
{
	protected $_group = 'salesroot';
	
    protected function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
		
        $this->loadLayout()
        	->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('reports')->__('Sales'), Mage::helper('reports')->__('Sales'));
        $this->initLayoutMessages('adminhtml/session');
        return $this;
    }
    
    public function kassenzeichenAction()
    {
         $this->_initAction()
         	->_setActiveMenu('report/salesroot/kassenzeichen')
         	->_addBreadcrumb(Mage::helper('extreport')->__('Kassenzeichen'), Mage::helper('extreport')->__('Kassenzeichen'))
         	->_addContent($this->getLayout()->createBlock('extreport/sales_kassenzeichen'))
         	->renderLayout();
    }
    
 	public function revenueAction()
    {
         $this->_initAction()
         	->_setActiveMenu('report/salesroot/revenue')
         	->_addBreadcrumb(Mage::helper('extreport')->__('Revenue'), Mage::helper('extreport')->__('Revenue'))
         	->_addContent($this->getLayout()->createBlock('extreport/sales_revenue'))
         	->renderLayout();
    }
    
    public function costunitAction()
    {
    	Mage::getSingleton('adminhtml/session')->addNotice($this->__('Last 30 days are shown by default.'));
    	$this->_initAction()
    	->_setActiveMenu('report/salesroot/costunit')
    	->_addBreadcrumb(Mage::helper('extreport')->__('Revenue'), Mage::helper('extreport')->__('Revenue'))
    	->_addContent($this->getLayout()->createBlock('extreport/sales_costunit'))
    	->renderLayout();
    }
    
	public function quantityorderedAction()
    {
        $this->_initAction()
            ->_setActiveMenu('report/salesroot/quantityordered')
            ->_addBreadcrumb(Mage::helper('extreport')->__('Sold Products'), Mage::helper('extreport')->__('Sold Products'))
            ->_addContent($this->getLayout()->createBlock('extreport/sales_quantityordered'))
            ->renderLayout();
    }
    
    public function haushaltsstelleAction()
    {
    	     $this->_initAction()
            ->_setActiveMenu('report/salesroot/haushaltsstelle')
            ->_addBreadcrumb('Haushaltsstelle', 'Haushaltsstelle')
            ->_addContent($this->getLayout()->createBlock('extreport/sales_haushaltsstelle'))
            ->renderLayout();
    }
    
	public function weightAction()
    {
        $this->_initAction()
            ->_setActiveMenu('report/salesroot/weight')
            ->_addBreadcrumb(Mage::helper('extreport')->__('Weight per Order'), Mage::helper('extreport')->__('Weight per Order'))
            ->_addContent($this->getLayout()->createBlock('extreport/sales_weight'))
            ->renderLayout();
    }
    
    public function gridAction()
    {
    	$this->loadLayout();
        
        $act = $this->getRequest()->getParam("action");
        if (!$act)
        	$act = "default";
        
        if ($act && $act != 'default') {
	        $this->getResponse()->setBody(
	            $this->getLayout()->createBlock('extreport/sales_'.$act.'_grid')->toHtml()
	        );
        } else {
        	$this->_forward('noRoute');
        }
    }
  	
	public function exportKassenzeichenCsvAction()
    {
        $fileName   = 'sales_kassenzeichen.csv';
        $content    = $this->getLayout()->createBlock('extreport/sales_kassenzeichen_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportKassenzeichenExcelAction()
    {
        $fileName   = 'sales_kassenzeichen.xml';
        $content    = $this->getLayout()->createBlock('extreport/sales_kassenzeichen_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportOutstandingCsvAction()
    {
        $fileName   = 'sales_oustanding.csv';
        $content    = $this->getLayout()->createBlock('extreport/sales_outstanding_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportOutstandingExcelAction()
    {
        $fileName   = 'sales_outstanding.xml';
        $content    = $this->getLayout()->createBlock('extreport/sales_outstanding_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportQuantityCsvAction()
    {
        $fileName   = 'sales_quantity.csv';
        $content    = $this->getLayout()->createBlock('extreport/sales_quantityordered_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
 
    public function exportQuantityExcelAction()
    {
        $fileName   = 'sales_quantity.xml';
        $content    = $this->getLayout()->createBlock('extreport/sales_quantityordered_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
    
	public function exportHaushaltsstelleCsvAction()
    {
        $fileName   = 'sales_haushaltsstelle.csv';
        $content    = $this->getLayout()->createBlock('extreport/sales_haushaltsstelle_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
 
    public function exportHaushaltsstelleExcelAction()
    {
        $fileName   = 'sales_haushaltsstelle.xml';
        $content    = $this->getLayout()->createBlock('extreport/sales_haushaltsstelle_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
    public function exportRevenueCsvAction()
    {
        $fileName   = 'sales_revenue.csv';
        $content    = $this->getLayout()->createBlock('extreport/sales_revenue_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
    public function exportRevenueExcelAction()
    {
        $fileName   = 'sales_revenue.xml';
        $content    = $this->getLayout()->createBlock('extreport/sales_revenue_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
    public function exportCostunitCsvAction()
    {
    	$fileName   = 'sales_costunit.csv';
    	$content    = $this->getLayout()->createBlock('extreport/sales_costunit_grid')
    						->getCsv()
    	;
    
    	$this->_prepareDownloadResponse($fileName, $content);
    }
    
    public function exportCostunitExcelAction()
    {
    	$fileName   = 'sales_costunit.xml';
    	$content    = $this->getLayout()->createBlock('extreport/sales_costunit_grid')
    						->getExcel($fileName)
    	;
    
    	$this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportWeightCsvAction()
    {
        $fileName   = 'sales_weight.csv';
        $content    = $this->getLayout()->createBlock('extreport/sales_weight_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

 
    public function exportWeightExcelAction()
    {
        $fileName   = 'sales_weight.xml';
        $content    = $this->getLayout()->createBlock('extreport/sales_weight_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }

}