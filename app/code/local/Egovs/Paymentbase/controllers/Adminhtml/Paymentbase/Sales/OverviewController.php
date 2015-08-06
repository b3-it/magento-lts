<?php
/**
 * Controller für Überblicks Grid
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_Sales_OverviewController extends Mage_Adminhtml_Controller_Sales_Invoice //Mage_Adminhtml_Controller_Action
{
    /**
     * Export nach CSV
     * 
     * @return void
     */
    public function exportCsvAction() {
        $fileName   = 'invoices.csv';
        $grid       = $this->getLayout()->createBlock('paymentbase/adminhtml_sales_overview_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export nach Excel XML
     *  
     *  @return void
     */
    public function exportExcelAction() {
        $fileName   = 'invoices.xml';
        $grid       = $this->getLayout()->createBlock('paymentbase/adminhtml_sales_overview_grid');
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
            $this->getLayout()->createBlock('paymentbase/adminhtml_sales_overview_grid')->toHtml()
        );
    }

    /**
     * Standard Aktion
     * 
     * @return void
     */
    public function indexAction()
    {
        //$this->_title($this->__('Sales'))->_title($this->__('Invoices'));

        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('paymentbase/adminhtml_sales_overview'))
            ->renderLayout();
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('sales/order_overview');
    			break;
    	}
    }
}
