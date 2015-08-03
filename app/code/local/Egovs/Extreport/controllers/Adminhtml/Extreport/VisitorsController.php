<?php

/**
 * Besucher-Report-Controller
 * 
 * Behandelt die Reports im Menü Besucher
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Adminhtml_Extreport_VisitorsController extends Egovs_Extreport_Controller_Abstract
{
	protected $_group = 'visitorsroot';
	
	protected function _isAllowed() {
		try {
			$action = 'visitstotal';
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
            ->_addBreadcrumb(Mage::helper('reports')->__('Visitors'), Mage::helper('reports')->__('Visitors'));
        return $this;
    }
    
    
  
    public function totalsAction()
    {
        $this->_initAction()
            ->_setActiveMenu('report/visitorsroot/visitstotal')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Total'), Mage::helper('adminhtml')->__('Total'))
            ->_addContent($this->getLayout()->createBlock('extreport/visitors_totals'))
            ->renderLayout();
    }
    
	public function gridAction()
    {
    	$this->loadLayout();
        
        $act = $this->getRequest()->getParam("action");
        if (!$act)
        	$act = "default";
        
        if ($act && $act != 'default') {
	        $this->getResponse()->setBody(
	            $this->getLayout()->createBlock('extreport/visitors_'.$act.'_grid')->toHtml()
	        );
        } else {
        	$this->_forward('noRoute');
        }
    }

    public function exportTotalsCsvAction()
    {
        $fileName   = 'visitors_totals.csv';
        $content    = $this->getLayout()->createBlock('extreport/visitors_totals_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

 
    public function exportTotalsExcelAction()
    {
        $fileName   = 'visitors_totals.xml';
        $content    = $this->getLayout()->createBlock('extreport/visitors_totals_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }

}