<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Adminhtml_Ibewi_Report_AttributeController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Adminhtml_Ibewi_Report_AttributeController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('reportattribute/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Report Kontierung'), Mage::helper('adminhtml')->__('Report Kontierung'));
		$this->_title(Mage::helper('adminhtml')->__('Report Kontierung'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}


	private function getFilename()
	{
		return  'ArtikelKontierung_'.  date('y_m_d');
	}

    public function exportCsvAction()
    {
        $fileName   =  $this->getFilename()  .'.csv';
        $content    = $this->getLayout()->createBlock('ibewi/adminhtml_report_attribute_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = $this->getFilename()  .'.xml';
        $content    = $this->getLayout()->createBlock('ibewi/adminhtml_report_attribute_grid')
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
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('report/products/ibewi_report_attribute');
    			break;
    	}
    }
}
