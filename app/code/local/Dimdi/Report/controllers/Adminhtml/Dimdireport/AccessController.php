<?php
/**
 * Dimdi_Report
 *
 *
 * @category   	Dimdi_Report
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Adminhtml_AccessController
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Adminhtml_Dimdireport_AccessController extends Dimdi_Report_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/dimdireport')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	
    public function exportCsvAction()
    {
        $fileName   = 'access.csv';
        $content    = $this->getLayout()->createBlock('dimdireport/adminhtml_access_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content, Dimdi_Report_Model_Access_Type::ACCESS);
    }

    public function exportXmlAction()
    {
        $fileName   = 'access.xml';
        $content    = $this->getLayout()->createBlock('dimdireport/adminhtml_access_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content, Dimdi_Report_Model_Access_Type::ACCESS);
    }

  
}