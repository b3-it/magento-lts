<?php

/**
 *
 * Inwards reports admin controller
 *
 * @category   Egovs
 * @package    Egovs_Extreport
 */
class Egovs_Extstock_Adminhtml_Extstock_ReportController extends Egovs_Extreport_Controller_Abstract
{
	protected $_group = 'extstockroot';
	
    public function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';

        $this->loadLayout()
            ->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('reports')->__('Extstock'), Mage::helper('reports')->__('Extstock'));
        return $this;
    }    
    
	public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('extstock/adminhtml_extstock_inwards_grid')->toHtml()
        );
    }
  
    public function inwardsAction()
    {
        $this->_initAction()
            ->_setActiveMenu('report/extstockroot/inwards')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Inwards'), Mage::helper('adminhtml')->__('Inwards'))
            ->_addContent($this->getLayout()->createBlock('extstock/adminhtml_extstock_inwards'))
            ->renderLayout();
    }

    public function exportInwardsCsvAction()
    {
        $fileName   = 'extstock_inwards.csv';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_extstock_inwards_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }
 
    public function exportInwardsExcelAction()
    {
        $fileName   = 'extstock_inwards.xml';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_extstock_inwards_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }

}