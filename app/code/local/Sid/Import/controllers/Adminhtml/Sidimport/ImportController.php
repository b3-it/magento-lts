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

    
    private function __testimport()
    {
    	$xml = file_get_contents(__DIR__.'/bmecat-bundle.xml');
    	$products = new B3it_XmlBind_Bmecat2005_Bmecat();
    	$products->bindXml($xml);
    	/* @var $builder Sid_Import_Model_Builder_Itw */
    	$builder = Mage::getModel('sidimport/builder_itw');
    	$builder->setSkuPrefix("los1");
       
    	$builder->setImageDispersionPrefix('L');
    	
    	 
    	$taxclass = array();
    	$taxclass[0] = 1;
    	$taxclass[19] = 1;
    	$taxclass[7] = 1;
    	
    	$builder->setTaxRates($taxclass);
    	 
    	foreach ($products->getTNewCatalog()->getAllProduct() as $import) {
    		
    			$article = new Sid_Import_Model_Builder_Item_Product2005($import);
    			$builder->addItem($article);
    		
    	}
    	$builder->save(null);
    }
    
  
    
    public function indexAction() {
    		//$this->__testimport();
    		$this->loadLayout();
    		$this->_setActiveMenu('system/convert');
    
    		$this->_addBreadcrumb($this->__('Import'), $this->__('Import'));
    
    		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
    
    		$this->_addContent($this->getLayout()->createBlock('sidimport/adminhtml_import_edit'))
    		->_addLeft($this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tabs'));
    
    		$this->renderLayout();
    	
    }
    
    public function gridAction()
    {
    	$this->loadLayout(false);
    	$this->renderLayout();
    	/*
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tab_grid')->toHtml());
    			*/
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
    		$this->_setActiveMenu('system/convert');
    
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
    			
    			
    			/* @var $builder Sid_Import_Model_Builder_Itw */
    			$builder = Mage::getModel('sidimport/builder_itw');
    			$builder->setSkuPrefix($defaults['sku_prefix'].$defaults['los']."/");
    			$builder->setCategoryId($defaults['category']);
    			$builder->setWebSiteId($defaults['website']);
    			$builder->setLos($defaults['los']);
    			$builder->setFramecontractQty($defaults['qty']);
    			$builder->setStockQuantity($defaults['qty']);
    			$builder->setStore($defaults['store']);
    			$builder->setImageDispersionPrefix('L'.$defaults['los']);
    			 
    			
    			$taxclass = array();
    			$taxclass[0] = $defaults['tax_class1'];
    			$taxclass[$defaults['tax_rate2']] = $defaults['tax_class2'];
    			$taxclass[$defaults['tax_rate3']] = $defaults['tax_class3'];

    			$builder->setTaxRates($taxclass);
    			
    			foreach ($importIds as $importId) {
    				$import = Mage::getModel('sidimport/storage')->load($importId);
    				$type = $import->getImportType();
    				if ($type == "bmecat2005_article") {
    					$article = new Sid_Import_Model_Builder_Item_Article2005($import->getImportdata(),true);
    					$builder->addItem($article);
    				} else if ($type == "bmecat2005_product") {
    					$article = new Sid_Import_Model_Builder_Item_Product2005($import->getImportdata(),true);
    					$builder->addItem($article);
    				} else {
    					throw new Exception("unknown BME import type '{$type}'!");
    					//TODO do exception!!!
    				}
    			}
    			
    			$builder->save($imageLoader);
    			Mage::getSingleton('adminhtml/session')->addSuccess(
    					Mage::helper('adminhtml')->__(
    							'Total of %d record(s) were successfully imported', count($importIds)
    							)
    					);
    			
    			//zur Artikelverwaltung weiterleiten (mit Filter auf die importierten Produkte)
    			$from = $builder->getFirstEntityId();
    			$to = $builder->getLastEntityId();
    			$filter = "entity_id[from]={$from}&entity_id[to]={$to}";
    			$filter = base64_encode($filter);
    			$this->_redirect('*/catalog_product/index',array('product_filter'=>$filter));
    			return;
    		} catch (Exception $e) {
    			Mage::logException($e);
    			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		}
    	}
    	$this->_redirect('*/*/index');
    }
}
