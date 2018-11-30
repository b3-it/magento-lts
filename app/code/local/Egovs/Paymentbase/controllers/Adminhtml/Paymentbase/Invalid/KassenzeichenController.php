<?php
/**
 * Controller zur Abfrage der Zahlungseingänge
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Controller_Action
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_Invalid_KassenzeichenController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Init
	 *
	 * @return Egovs_Paymentbase_Adminhtml_Paymentbase_Invalid_KassenzeichenController
	 */
	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
            
		$this->loadLayout()
			->_setActiveMenu('sales/invalid_kassenzeichen')
			->_addBreadcrumb(Mage::helper('paymentbase')->__('Invalid Kassenzeichen'), Mage::helper('paymentbase')->__('Invalid Kassenzeichen'));
		
		return $this;
	}   
 
	/**
	 * Standard Aktion
	 *
	 * @return void
	 */
	public function indexAction() {
	
		$this->_initAction()
			->renderLayout();
	}
	
	/**
     * Product grid für AJAX request
     * 
     * @return void
     */
    public function gridAction() {
    	$this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('paymentbase/adminhtml_invalid_kassenzeichen_grid')->toHtml()
        );
    }
    
    /**
     * Magic Method
     * 
     * Kapselt Export-Aktionen
     * 
     * @param string $method Methode
     * @param array  $args   Parameter
     * 
     * @return void
     */
    public function __call($method, $args) {
    	switch (substr($method, 0, 6)) {
    		case 'export' :
    			//Varien_Profiler::start('GETTER: '.get_class($this).'::'.$method);
    			$key = substr($method,6);
    			$pos = stripos($key, 'Csv');
    			$isExcel = false;
    			if ($pos === false) {
    				$pos = stripos($key, 'Excel');
    				if ($pos === false) {
    					$pos = stripos($key, 'Xml');
    				}
    				$isExcel = true;
    			}
    			if ($pos === false) {
    				$this->_forward('noRoute');
    				return;
    			}
    
    			$method = strtolower(substr($key,0,$pos));
    
    			$fileName   = 'sales_'.$method;
    			$isExcel ? $fileName .= ".xml" : $fileName .= ".csv";
    
    			if ($isExcel) {
    				$content    = $this->getLayout()->createBlock('paymentbase/adminhtml_invalid_'.$method.'_grid')
    					->getExcel($fileName);
    			} else {
    				$content    = $this->getLayout()->createBlock('paymentbase/adminhtml_invalid_'.$method.'_grid')
    					->getCsv($fileName);
    			}
    
    			$this->_prepareDownloadResponse($fileName, $content);
    			//Varien_Profiler::stop('GETTER: '.get_class($this).'::'.$method);
    			return;
    	}
    
    	$this->_forward('noRoute');
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('sales/invalid_kassenzeichen');
    			break;
    	}
    }
}