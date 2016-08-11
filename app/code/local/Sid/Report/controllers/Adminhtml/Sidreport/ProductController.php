<?php
/**
 * Sid Report
 *
 *
 * @category   	Sid
 * @package    	Sid_Report
 * @name       	Sid_Report_Adminhtml_ProductController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Report_Adminhtml_Sidreport_ProductController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('product/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}


	protected function _isAllowed()
	{
		return true;
		switch ($this->getRequest()->getActionName()) {
			case 'stock':
				return $this->_getSession()->isAllowed('report/products/frame_contract_product_report');
				break;
			case 'exportSalesCsv':
				return $this->_getSession()->isAllowed('report/products/frame_contract_product_report');
				break;
			case 'exportSalesExcel':
				return $this->_getSession()->isAllowed('report/products/frame_contract_product_report');
				break;
	
	
		}
	}

    public function exportCsvAction()
    {
        $fileName   = 'product.csv';
        $content    = $this->getLayout()->createBlock('report/adminhtml_product_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'product.xml';
        $content    = $this->getLayout()->createBlock('report/adminhtml_product_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}
