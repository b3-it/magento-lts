<?php

/**
 *
 * Visitors reports admin controller
 *
 * @category   Egovs
 * @package    Egovs_Extreport
 */
class Egovs_EventBundle_Adminhtml_Eventbundle_ReportController extends Mage_Adminhtml_Controller_Action
{
	protected $_base = 'report';
	
	protected $_group = 'salesroot';
	
	protected function _isAllowed() {	
			return Mage::getSingleton('admin/session')->isAllowed('report/salesroot/eventbundleoptions');
	}
	
	
    public function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
		
        $this->loadLayout()
        	->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('reports')->__('Sales'), Mage::helper('reports')->__('Sales'));
        return $this;
    }
    
   
    
	public function optionsAction()
    {
         $this->_initAction()
         	->_setActiveMenu('report/salesroot/poptions')
         	->_addBreadcrumb(Mage::helper('eventbundle')->__('Product Options'), Mage::helper('eventbundle')->__('Product Options'))
         	/* TODO : Layout XML benutzen! */
         	->_addContent($this->getLayout()->createBlock('eventbundle/adminhtml_report_options'))
         	->renderLayout();
    }
    
    public function exportOptionsCsvAction()
    {
    	$fileName   = 'eventbundle.csv';
    	$content    = $this->getLayout()->createBlock('eventbundle/adminhtml_report_options_grid')
    	->getCsv($fileName);
    	$this->_prepareDownloadResponse($fileName, $content);
    }
    
    public function exportOptionsExcelAction()
    {
    	$fileName   = 'eventbundle.xls';
    	$content    = $this->getLayout()->createBlock('eventbundle/adminhtml_report_options_grid')
    	->getExcel($fileName);
    	$this->_prepareDownloadResponse($fileName, $content);
    }
    
    
	public function gridAction()
    {
    	$this->loadLayout();
        
	        $this->getResponse()->setBody(
	            $this->getLayout()->createBlock('eventbundle/report_options')->toHtml()
	        );
        
    }
    

    
    
}