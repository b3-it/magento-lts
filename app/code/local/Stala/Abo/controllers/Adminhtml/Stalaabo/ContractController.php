<?php

class Stala_Abo_Adminhtml_Stalaabo_ContractController extends Egovs_Base_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('stalaabo/contract')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		Mage::getSingleton('adminhtml/session')->unsetData('customer_id');
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_contract'))
			->renderLayout();
	}

    public function newAction()
    {
        $this->_getSession()->clear();
        $this->_redirect('*/*/customer');
    }
    
    
    public function customerAction()
    {
    	$this->_initAction()
    		->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_contract_customer'))
			->renderLayout();
    }
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('stalaabo/contract')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('contract_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('stalaabo/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_contract_edit'));


			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stalaabo')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 

 

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('stalaabo/contract')->load($this->getRequest()->getParam('id'));

				$date = date('Y-m-d');
				$model->setIsDeleted('1')
						->setDeleteDate($date)
						->save();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

 
    public function exportCsvAction()
    {
        $fileName   = 'contract.csv';
        $content    = $this->getLayout()->createBlock('stalaabo/adminhtml_contract_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'contract.xml';
        $content    = $this->getLayout()->createBlock('stalaabo/adminhtml_contract_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('stalaabo/contract');
    			break;
    	}
    }
 
}