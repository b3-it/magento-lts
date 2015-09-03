<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Adminhtml_SalesController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Adminhtml_Slpbcustomer_SalesController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sales/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function massDeleteAction()
	{
		$customersIds = $this->getRequest()->getParam('customer');
		
		if(!is_array($customersIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select customer(s).'));
		} else {
			try {
				$customer = Mage::getModel('customer/customer');
				foreach ($customersIds as $customerId) {
					$customer->reset()
					->load($customerId)
					->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
				'Total of %d record(s) were deleted.', count($customersIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
	
		$this->_redirect('*/*/index');
	}
	
 

	
    public function gridAction()
    {
    	
    	$this->loadLayout();
    	$this->getResponse()->setBody($this->getLayout()->createBlock('slpbcustomer/adminhtml_sales_grid')->toHtml());
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('customer/slpbcustomer_lastorder');
    			break;
    	}
    }
}