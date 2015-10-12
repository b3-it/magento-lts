<?php

class Dwd_Stationen_Adminhtml_Stationen_ImportController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('import/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	
 
	
	public function importAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			setlocale(LC_ALL, "de_DE.ISO-8859-15@euro");
			$model = Mage::getModel('stationen/import');		
			
			
			try {
				
				$filename = $model->uploadSource();
				$total = $model->importSource($filename);
				if ($total == 0)
				{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stationen')->__('No valid Items found!'));
					$this->_redirect('*/*/import');
				}
				else
				{
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stationen')->__('%s Items are successfully processed!',$total));
					$this->_redirect('*/adminhtml_stationen/index');
				}
				
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/import');
                return;
            }
        }
       
        $this->_redirect('*/*/');
	}

	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed('stationen/import');
				break;
		}
	}
}