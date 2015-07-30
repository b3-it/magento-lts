<?php

class Egovs_Import_Adminhtml_Import_ExportController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('import/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Export Manager'), Mage::helper('adminhtml')->__('Export Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->loadLayout();
		//$this->getLayout()->createBlock('import/adminhtml_import_edit');
		//$this->_addContent($this->getLayout()->createBlock('import/adminhtml_export_edit'));
		$this->renderLayout();
	}



	public function exportAction() {
		$target = $this->getRequest()->getParam('export');
		$data = $this->getRequest()->getParams();
		$data['charset'] = 'utf8';
		if($target == "customer")
		{
			$res = $this->_exportCustomer($data);
			//die();
		}
		
		$s = sprintf("Es wurden %s Kunden und %s Adressen exportiert.", $res['customercount'], $res['addressescount']);
		
		//Mage::getSingleton('adminhtml/session')->addSuccess();
		
		
		$this->loadLayout();
		
        $this->getResponse()->setBody($s);
	}
 	
	private function _exportCustomer($data)
	{
		$export = Mage::getModel('egovsimport/export_customers');
		return $export->export($data['filename']);
	}
	


}