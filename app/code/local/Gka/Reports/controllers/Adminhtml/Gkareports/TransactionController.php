<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2017 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Adminhtml_Gkareports_TransactionController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/gka')
			//->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'))

            ;
        $this->_title(Mage::helper('adminhtml')->__('Report'));

		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}


    public function gridAction()
    {
        if(!$this->_validateFormKey()){
            $this->_redirect('customer/account/logout');
            return;
        }
        $this->loadLayout(false);
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('gka_reports/adminhtml_transaction_grid')->toHtml()
        );
    }



    public function exportCsvAction()
    {
        $fileName   = $this->_getFileName('csv');
        $content    = $this->getLayout()->createBlock('gka_reports/adminhtml_transaction_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = $this->_getFileName('xml');
        $content    = $this->getLayout()->createBlock('gka_reports/adminhtml_transaction_grid')
            ->getXml();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName   = $this->_getFileName('xls');
        $content    = $this->getLayout()->createBlock('gka_reports/transaction_grid')
            ->getExcel($fileName);
        $this->_prepareDownloadResponse($fileName, $content);
    }

    protected function _getFileName($ext = "csv")
    {
        $fileName   = $this->__('Transactions');
        $fileName .= "_".date('Y-m-d') . ".".$ext;

        return $fileName;

    }

}