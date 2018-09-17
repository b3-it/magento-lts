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
     * Initialize order model instance
     *
     * @return Mage_Sales_Model_Order || false
     */
    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
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
     * Grid Aktion
     *
     * Wird meist durch einen Ajax-Aufruf genutzt
     *
     * @return void
     */
    public function transactionsAction() {
        $this->loadLayout();
        $this->_initOrder();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('paymentbase/adminhtml_sales_incomingPayments_view_tab_transactions')->toHtml()
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
            ;
        $this->renderLayout();
    }

    public function resetAction() {
        $order = $this->_initOrder();
        if ($order) {
            $order->getPayment()->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT, 0);
            $order->getPayment()->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS, Egovs_Paymentbase_Model_Paymentbase::KASSENZEICHEN_STATUS_PROCESSING);
            $resource = $order->getPayment()->getResource();
            $resource->saveAttribute($order->getPayment(), array(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS));
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('Reset error status for Kassenzeichen %s', $order->getPayment()->getKassenzeichen()));
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Reset not possible no Kassenzeichen or order %s!', $this->getRequest()->getParam('order_id')));
        }

        $this->_redirect('*/*/index', array('order_id' => $this->getRequest()->getParam('order_id')));
    }

    /**
     * Standard Aktion
     *
     * @return void
     */
    public function viewAction() {
        $this->_initAction();
        $this->_initOrder();
        $this->renderLayout();
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
