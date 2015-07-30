<?php

/**
 * Kunden-Report-Controller
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Adminhtml_CustomerController extends Egovs_Extreport_Controller_Abstract
{
	protected $_group = 'customers';
	
	protected function _isAllowed() {
		try {
			$action = 'customeractivity';
			return Mage::getSingleton('admin/session')->isAllowed(sprintf("%s/%s/%s", $this->_base,$this->_group,$action));
		} catch (Exception $e) {
			return false;
		}
	}
	
    protected function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';

        $this->loadLayout()
            ->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('reports')->__('Customers'), Mage::helper('reports')->__('Activity'));
        return $this;
    }    
  
    public function activityAction()
    {
        $this->_initAction()
            ->_setActiveMenu('report/visitorsroot/visitstotal')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Total'), Mage::helper('adminhtml')->__('Total'))
            ->_addContent($this->getLayout()->createBlock('extreport/customer_activity'))
            ->renderLayout();
    }

	public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('extreport/customer_activity_grid')->toHtml()
        );
    }
    
    public function exportActivityCsvAction()
    {
        $fileName   = 'customer_activity.csv';
        $content    = $this->getLayout()->createBlock('extreport/customer_activity_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

 
    public function exportActivityExcelAction()
    {
        $fileName   = 'customer_activity.xml';
        $content    = $this->getLayout()->createBlock('extreport/customer_activity_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }

}