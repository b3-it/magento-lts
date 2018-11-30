<?php
/**
 *
 * @category   	Bfr Report
 * @package    	Bfr_Report
 * @name        Bfr_Report_Adminhtml_Report_Export_ExportedController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Report_Adminhtml_Report_Export_ExportedController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/salesroot')
			->_addBreadcrumb(Mage::helper('bfr_report')->__('Order Export'), Mage::helper('bfr_report')->__('Order Export'));
		$this->_title(Mage::helper('bfr_report')->__('Order Export'));
		return $this;
	}

	public function indexAction() {

	    $this->_initAction()
			->renderLayout();
	}

	protected function _saveExport()
	{
        $incoming_payment_ids = Mage::registry('incoming_payment_ids');
		$user = Mage::getSingleton('admin/session')->getUser();
		$export = Mage::getModel('bfr_report/export_exported');
		$export->saveHistory($incoming_payment_ids, trim($user->getFirstname()." ".$user->getLastname()));
	}
	
   
    public function exportCsvAction()
    {
        $fileName   = $this->_getFileName('csv');
        $content    = $this->getLayout()->createBlock('bfr_report/adminhtml_export_exported_grid')
            ->getCsv();

        $this->_saveExport();
        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportXmlAction()
    {
        $fileName   = $this->_getFileName('xml');
        $content    = $this->getLayout()->createBlock('bfr_report/adminhtml_export_exported_grid')
            ->getExcel($fileName);
            $this->_saveExport();
        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportExcelAction()
    {
        $fileName   = $this->_getFileName('xls');
        $content    = $this->getLayout()->createBlock('bfr_report/adminhtml_export_exported_grid')
            ->getXml();
            $this->_saveExport();
         $this->_prepareDownloadResponse($fileName,$content);
    }

    protected function _getFileName($ext = "csv")
    {
    	  $fileName   = $this->__('exportexported');
    	$fileName .= "_".date('Y-m-d') . ".".$ext;

    	return $fileName;
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('report/salesroot/bfrreport_export_exported');
    }
  
}
