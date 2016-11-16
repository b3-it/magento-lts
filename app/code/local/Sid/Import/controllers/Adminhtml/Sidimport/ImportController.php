<?php

class Sid_Import_Adminhtml_Sidimport_ImportController extends Mage_Adminhtml_Controller_Action
{
   

    /**
     * Check access (in the ACL) for current user.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/convert/supplierportal_import');
    }

  
    
    public function indexAction() {
    		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    		if (!empty($data)) {
    			$model->setData($data);
    		}
    
    		//Mage::register('import_data', $model);
    
    		$this->loadLayout();
    		$this->_setActiveMenu('import/items');
    
    		$this->_addBreadcrumb($this->__('Import'), $this->__('Import'));
    
    		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
    
    		$this->_addContent($this->getLayout()->createBlock('sidimport/adminhtml_import_edit'))
    		->_addLeft($this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tabs'));
    
    		$this->renderLayout();
    	
    }
    
    public function gridAction()
    {
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tab_grid')->toHtml());
    }
    
	public function fetchAction() {
    		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    		if (!empty($data)) {
    			$model->setData($data);
    		}
    		$losId =  intval($this->getRequest()->getParam('los'));
    		$restClient = Mage::getModel('sidimport/restImport');
    		$restClient->importProductList($losId);
    		
    		
    		
    		//Mage::register('import_data', $model);
    
    		$this->loadLayout();
    		$this->_setActiveMenu('import/items');
    
    		$this->_addBreadcrumb($this->__('Import'), $this->__('Import'));
    
    		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
    
    		$blockTab = $this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tabs');
    		$this->_addContent($this->getLayout()->createBlock('sidimport/adminhtml_import_edit'))
    		->_addLeft($blockTab);
    
    		$this->renderLayout();
    	
    }

    public function massImportAction() {
    	$importIds = $this->getRequest()->getParam('import_ids');
    	if(!is_array($importIds)) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
    	} else {
    		try {
    			/* @var $builder Sid_Import_Model_Itw */
    			$builder = Mage::getModel('sidimport/Itw');
    			$builder->setSkuPrefix('prefix');
    			
    			
    			
    			foreach ($importIds as $importId) {
    				$import = Mage::getModel('sidimport/storage')->load($importId);
    				
    				$article = new B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Article($import->getImportdata(),true);
    				$builder->addItem($article);
    				
    			}
    			
    			$builder->save();
    			Mage::getSingleton('adminhtml/session')->addSuccess(
    					Mage::helper('adminhtml')->__(
    							'Total of %d record(s) were successfully imported', count($importIds)
    							)
    					);
    		} catch (Exception $e) {
    			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		}
    	}
    	$this->_redirect('*/*/index');
    }
}
