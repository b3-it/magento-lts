<?php

/**
 * Produkt-Report-Controller
 * 
 * Behandelt die Reports im Menü Produkte
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Adminhtml_Extreport_ProductController extends Egovs_Extreport_Controller_Abstract
{
	protected $_group = 'products';
	
    protected function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';

        $this->loadLayout()
        	->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('reports')->__('Product'), Mage::helper('reports')->__('Product'));
        return $this;
    }
    
 	public function overviewAction()
    {
    	$this->_initAction()
         	->_setActiveMenu('report/products/overview')
         	->_addBreadcrumb(Mage::helper('extreport')->__('Overview'), Mage::helper('extreport')->__('Overview'))
         	->_addContent($this->getLayout()->createBlock('extreport/product_overview'))
         	->renderLayout();
    }
    
	public function shippedAction()
    {
    	$this->_initAction()
         	->_setActiveMenu('report/products/shipped')
         	->_addBreadcrumb(Mage::helper('extreport')->__('Shipped'), Mage::helper('extreport')->__('Shipped'))
         	->_addContent($this->getLayout()->createBlock('extreport/product_shipped'))
         	->renderLayout();
    }
    
	public function stockflowAction()
    {
    	$this->_initAction()
         	->_setActiveMenu('report/products/stockflow')
         	->_addBreadcrumb(Mage::helper('extreport')->__('Stock flow'), Mage::helper('extreport')->__('Stock flow'))
         	->_addContent($this->getLayout()->createBlock('extreport/product_stockflow'))
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
	            $this->getLayout()->createBlock('extreport/product_'.$act.'_grid')->toHtml()
	        );
        } else {
        	$this->_forward('noRoute');
        }
    }
  
  

    public function exportOverviewsCsvAction()
    {
        $fileName   = 'products_overview.csv';
        $content    = $this->getLayout()->createBlock('extreport/product_overview_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

 
    public function exportOverviewsExcelAction()
    {
        $fileName   = 'products_overview.xml';
        $content    = $this->getLayout()->createBlock('extreport/product_overview_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportShippedCsvAction()
    {
        $fileName   = 'products_shipped.csv';
        $content    = $this->getLayout()->createBlock('extreport/product_shipped_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
    public function exportShippedExcelAction()
    {
        $fileName   = 'products_Shipped.xml';
        $content    = $this->getLayout()->createBlock('extreport/product_shipped_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
	
	public function exportStockflowCsvAction()
    {
        $fileName   = 'products_stockflow.csv';
        $content    = $this->getLayout()->createBlock('extreport/product_stockflow_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
    
	public function exportStockflowExcelAction()
    {
        $fileName   = 'products_Stockflow.xml';
        $content    = $this->getLayout()->createBlock('extreport/product_stockflow_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
}