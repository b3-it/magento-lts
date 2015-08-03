<?php

class Egovs_Extnewsletter_Adminhtml_Extnewsletter_ReportController extends Mage_Adminhtml_Controller_Action
{
	
	public function ProductsAction()
	{
		$this->loadLayout()->renderLayout();
	}
	
	public function IssuesAction()
	{
		$this->loadLayout()->renderLayout();
		
	}
	
	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed("report/customers/$action");
				break;
		}
	}

}