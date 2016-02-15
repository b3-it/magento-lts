<?php
/**
 * Dimdi Reports
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi Report
 * @name        Dimdi_Report_Adminhtml_OrderController
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Adminhtml_Dimdireport_OrderController extends Dimdi_Report_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/dimdireport')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Report'), Mage::helper('dimdireport')->__('Rechnungen'));
		
		return $this;
	}   
 
	public function indexAction() {
		try 
		{
			$this->_initAction();
			//$this->verifyDate();
			$this->renderLayout();
		}
		catch(Exception $ex)
		{
			Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
			$this->_redirect('*/*/');
		}
	}


  
    public function exportCsvAction()
    {
        $fileName   = 'order.csv';
        $content    = $this->getLayout()->createBlock('dimdireport/adminhtml_order_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content, Dimdi_Report_Model_Access_Type::ORDER);
    }

    public function exportXmlAction()
    {
        $fileName   = 'order.xml';
        $content    = $this->getLayout()->createBlock('dimdireport/adminhtml_order_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content, Dimdi_Report_Model_Access_Type::ORDER);
    }

    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	$fullAction = strtolower($this->getRequest()->getRequestedRouteName());
    	switch ($action) {
    		default:
    				return Mage::getSingleton('admin/session')->isAllowed('report/dimdireport/order');
    			break;
    	}
    }
  
}