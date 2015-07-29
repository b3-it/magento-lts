<?php

class Egovs_Import_Adminhtml_Import_ImportController extends Mage_Adminhtml_Controller_action
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
		//$this->_addContent($this->getLayout()->createBlock('import/adminhtml_import_edit'));
		$this->renderLayout();
	}



	public function importCustomerAction()
	{
		$data = $this->getRequest()->getPost();
		if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
			try {
				/* Starting upload */
				$uploader = new Varien_File_Uploader('filename');
					
				// Any extention would work
				$uploader->setAllowedExtensions(array('xml'));
				$uploader->setAllowRenameFiles(false);
				$uploader->setFilesDispersion(false);
					
				// We set media as the upload dir
				$path = Mage::getBaseDir('var') . DS  .'tmp' .DS;
				$uploader->save($path, $_FILES['filename']['name'] );
				
				$data['filename'] = $path . $_FILES['filename']['name'];
				$model = Mage::getModel('egovsimport/customers');
				
				$i = $model->import($data);
				
				$s = sprintf("Es wurden %s Kunden importiert.", $i);
				Mage::getSingleton('adminhtml/session')->addSuccess($s);
				
				
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
			}
			 
			//this way the name is saved in DB
			
		}
		else
		{
			Mage::getSingleton('adminhtml/session')->addError("Datei nicht gefunden!");
			Mage::getSingleton('adminhtml/session')->setFormData($data);
		}
			
			
			
			$this->loadLayout();
			$this->_addContent($this->getLayout()->createBlock('import/adminhtml_import_edit'));
			$this->renderLayout();
			
		
	}
	
	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed('egovs_import');
				break;
		}
	}

}