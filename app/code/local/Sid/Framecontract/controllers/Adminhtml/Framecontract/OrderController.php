<?php

class Sid_Framecontract_Adminhtml_Framecontract_OrderController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('order/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function exportCsvAction()
    {
        $fileName   = 'order.csv';
        $content    = $this->getLayout()->createBlock('framecontract/adminhtml_order_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'order.xml';
        $content    = $this->getLayout()->createBlock('framecontract/adminhtml_order_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

   
}