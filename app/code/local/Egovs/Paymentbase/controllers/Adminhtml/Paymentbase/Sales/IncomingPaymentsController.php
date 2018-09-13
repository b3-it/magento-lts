<?php

/**
 * Class Egovs_Paymentbase_Adminhtml_Paymentbase_Sales_IncomingPaymentsController
 *
 * @category  Egovs
 * @package   Egovs_Paymentbase
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_Sales_IncomingPaymentsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init layout, menu and breadcrumb
     *
     * @return Mage_Adminhtml_Sales_InvoiceController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales/order')
            ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
            ->_addBreadcrumb($this->__('Incoming Payments'),$this->__('Incoming Payments'));
        return $this;
    }

    /**
     * Export nach CSV
     * 
     * @return void
     */
    public function exportCsvAction() {
        $fileName   = 'incoming_payments.csv';
        $grid       = $this->getLayout()->createBlock('paymentbase/adminhtml_sales_incomingPayments_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export nach Excel XML
     *  
     *  @return void
     */
    public function exportExcelAction() {
        $fileName   = 'incoming_payments.xml';
        $grid       = $this->getLayout()->createBlock('paymentbase/adminhtml_sales_incomingPayments_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
    
    
    /**
     * Grid Aktion
     * 
     * Wird meist durch einen Ajax-Aufruf genutzt
     * 
     * @return void
     */
    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('paymentbase/adminhtml_sales_incomingPayments_grid')->toHtml()
        );
    }

    /**
     * Standard Aktion
     * 
     * @return void
     */
    public function indexAction() {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('paymentbase/adminhtml_sales_incomingPayments'))
            ->renderLayout();
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('sales/incoming_payments');
    			break;
    	}
    }
}
