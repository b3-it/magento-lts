<?php

class Dimdi_Import_Adminhtml_ImportController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('import/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->loadLayout();
		//$this->getLayout()->createBlock('import/adminhtml_import_edit');
		$this->_addContent($this->getLayout()->createBlock('import/adminhtml_import_edit'));
		$this->renderLayout();
	}



	public function importAction() {
		$target = $this->getRequest()->getParam('import');
		$data = $this->getRequest()->getParams();
		$data['charset'] = 'utf8';
		if($target == "customer")
		{
			$this->_importCustomer($data);
			die();
		}
		if($target == "category")
		{
			$this->_importCategory($data);
			die();
		}
		
		if($target == "products")
		{
			$this->_importProducts($data);
			die();
		}
		
		if($target == "orders")
		{
			$this->_importOrders($data);
			die();
		}
		
		if($target == "hparameter")
		{
			$this->_importHparameter($data);
			die();
		}
		
		
		
		
		$this->loadLayout();
		
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('import/adminhtml_import_edit')->toHtml());
	}
 	
	private function _importCustomer($data)
	{
		$conn = new Varien_Db_Adapter_Pdo_Mysql($data);
		
		if($conn)
		{
			$model = Mage::getModel('dimdiimport/customer');
			$res = $model->run($conn);
			echo $res;
			
			
		}
	}
	
	private function _importCategory($data)
	{
		$conn = new Varien_Db_Adapter_Pdo_Mysql($data);
		
		if($conn)
		{
			$model = Mage::getModel('dimdiimport/category');
			$res = $model->run($conn);
			echo $res;
			
			
		}
	}
	
	private function _importProducts($data)
	{
		$conn = new Varien_Db_Adapter_Pdo_Mysql($data);
		
		if($conn)
		{
			$model = Mage::getModel('dimdiimport/product');
			$res = $model->run($conn);
			echo $res;
			
			
		}
	}
	private function _importOrders($data)
	{
		$conn = new Varien_Db_Adapter_Pdo_Mysql($data);
		
		if($conn)
		{
			$model = Mage::getModel('dimdiimport/order');
			$res = $model->run($conn);
			echo $res;
			
			
		}
	}
	
	private function _importHparameter($data)
	{
		$conn = new Varien_Db_Adapter_Pdo_Mysql($data);
		
		if($conn)
		{
			$model = Mage::getModel('dimdiimport/hparameter');
			$res = $model->run($conn);
			echo $res;
				
				
		}
	}

}