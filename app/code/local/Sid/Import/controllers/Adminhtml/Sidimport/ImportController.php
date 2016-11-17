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
    
	public function saveAction() {
    		
    		if ($data = $this->getRequest()->getPost()) {
    		
    			$default = $data['default'];
    			/* @var $sessiion Mage_Core_Model_Session */
	    		$session = Mage::getSingleton("admin/session");
	    		$session->setImportDefaults($default);
	    		
	    		$losId =  intval($default['los']);
	    		$restClient = Mage::getModel('sidimport/restImport');
	    		$restClient->importProductList($losId);
    		}
    		
    		
    		//Mage::register('import_data', $model);
    
    		$this->loadLayout();
    		$this->_setActiveMenu('import/items');
    
    		$this->_addBreadcrumb($this->__('Import'), $this->__('Import'));
    
    		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
    
    		$blockTab = $this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tabs');
    		$blockTab->setShowProducts(true);
    		$this->_addContent($this->getLayout()->createBlock('sidimport/adminhtml_import_edit'))
    		->_addLeft($blockTab);
    
    		$this->renderLayout();
    	
    }

    private function getImportDefaults($key = NULL)
    {
    	$session = Mage::getSingleton("admin/session");
    	$defaults = $session->getImportDefaults();
    	if($key == null){
    		return $defaults;
    	}
    	
    	return $defaults[$key];
    }
    
    public function massImportAction() {
    	
    	$session = Mage::getSingleton("admin/session");
    	$defaults = $session->getImportDefaults();
    	
    	$importIds = $this->getRequest()->getParam('import_ids');
    	if(!is_array($importIds)) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
    	} else {
    		try {
    			
    			$imageLoader = new Sid_Import_Model_Imageloader();
    			$imageLoader->setLosId($defaults['los']);
    			
    			
    			/* @var $builder Sid_Import_Model_Itw */
    			$builder = Mage::getModel('sidimport/Itw');
    			$builder->setSkuPrefix($defaults['sku_prefix'].$defaults['los']."/");
    			$builder->setCategoryId($defaults['category']);
    			$builder->setWebSiteId($defaults['website']);
    			$builder->setLos($defaults['los']);
    			$builder->setFramecontractQty($defaults['qty']);
    			$builder->setStore($defaults['store']);
    			$builder->setImageDispersionPrefix('L'.$defaults['los']);
    			 
    			
    			$taxclass = array();
    			$taxclass[0] = $defaults['tax_class1'];
    			$taxclass[$defaults['tax_rate2']] = $defaults['tax_class2'];
    			$taxclass[$defaults['tax_rate3']] = $defaults['tax_class3'];

    			$builder->setTaxRates($taxclass);
    			
    			foreach ($importIds as $importId) {
    				$import = Mage::getModel('sidimport/storage')->load($importId);
    				
    				$article = new B3it_XmlBind_Bmecat2005_ProductBuilder_Item_Article($import->getImportdata(),true);
    				$builder->addItem($article);
    				
    			}
    			
    			$builder->save($imageLoader);
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
