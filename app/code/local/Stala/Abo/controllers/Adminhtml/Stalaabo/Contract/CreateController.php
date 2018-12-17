<?php

class Stala_Abo_Adminhtml_Stalaabo_Contract_CreateController extends Mage_Adminhtml_Controller_action
{
    
    public function customerAction()
    {
    	$this->_initAction()
    		->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_contract_customer'))
			->renderLayout();
    }
    
    public function customerGridAction()
    {
		$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('stalaabo/adminhtml_contract_customer_grid')->toHtml());
    }

    public function customerPostAction()
    {
    	$this->_getSession()->clear();
    	$customer_id = intval($this->getRequest()->getParam('customer_id'));
    	if($customer_id)
    	{
    		$contract = $this->_getContractItems();
    		$contract->setCustomerId($customer_id);
    	}
    	$this->_redirect('*/*/index');
    }
    
    protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('stalaabo/contract')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
    
	public function indexAction() 
	{
		$contract = $this->_getContractItems();
    	$customer_id = $contract->getCustomerId();
    	if($customer_id)
    	{	
			$this->_initAction()
				->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_contract_create'))
				->renderLayout();
    	}
    	else
    	{
    		$this->_redirect('*/*/customer');
    	}
	}
	
    public function productgridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('stalaabo/adminhtml_contract_create_product_grid')->toHtml());
    }
	
    private function _getContractItems()
    {
    	$res = Mage::getSingleton('adminhtml/session')->getData('abo_contract_create');
    	if($res == null)
    	{
    		$res = Mage::getModel('stalaabo/create');
    		Mage::getSingleton('adminhtml/session')->setData('abo_contract_create',$res);
    	}
    	
    	return $res;
    }
    
    
    public function addItemsAction()
    {
    	$contract = $this->_getContractItems();
    	$id = $this->getRequest()->getParam('id');
    	$contract->addItem($id);
    	$this->itemsListAction();
    }
    
    public function removeItemsAction()
    {
    	$contract = $this->_getContractItems();
    	$id = $this->getRequest()->getParam('id');
    	$contract->removeItem($id);
    	$this->itemsListAction();
    }
    
    public function itemsListAction()
    {
    	$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('stalaabo/adminhtml_contract_create_list')->toHtml());
    }
    
    
    private function savePostData($data)
    {
    	$contract = Mage::getModel('stalaabo/create');
    	if(isset($data['shipping_adr']))$contract->setShippingAddressId($data['shipping_adr']);
    	$contract->setCustomerId($data['customer_id']);
    	if(isset($data['billing_adr']))$contract->setBillingAddressId($data['billing_adr']);
    	
    	$items=array();
	    for($i = 0, $iMax = count($data['items']['id']); $i < $iMax; $i++)
	    {
		    	$item = new Varien_Object();	
		    	$item->setId($data['items']['id'][$i]);
		    	$item->setQty($data['items']['qty'][$i]);
		    	$items[$item->getId()] = $item;
		    			
	    }
		$contract->setItems($items);
	    Mage::getSingleton('adminhtml/session')->setData('abo_contract_create',$contract);
    }
    
    public function createPostAction()
    {
    	$contract = $this->getRequest()->getPost('create_contract');
    	try 
    	{
    		Mage::getSingleton('adminhtml/session')->unsetData('abo_contract_create');
	    	if($contract != null)
	    	{
	    		$this->savePostData($contract);
	    		if($contract['from_date']== null)
	    		{
	    			Mage::throwException($this->__('Enter From Date, please!'));
	    		}
	    		
	    		if((!isset($contract['items'])) || ($contract['items']== null) ||(count($contract['items']['id']) == 0))
	    		{
	    			Mage::throwException($this->__('Enter Contract Products, please!'));
	    		}
	    		
	    		if((!isset($contract['billing_adr'])) || ($contract['billing_adr']== null))
	    		{
	    			Mage::throwException($this->__('Enter Billing Address, please!'));
	    		}
	    		
	    		if((!isset($contract['shipping_adr'])) || ($contract['shipping_adr']== null))
	    		{
	    			Mage::throwException($this->__('Enter Shipping Address, please!'));
	    		}
	    		
	    		if((!isset($contract['from_date'])) || ($contract['from_date']== null))
	    		{
	    			Mage::throwException($this->__('Enter Date, please!'));
	    		}
	    		
	    		
	    		$fromDate = Mage::app()->getLocale()->date($contract['from_date'],Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT));
	    		//$fromDate =($contract['from_date']);
	    		
	    		for($i = 0, $iMax = count($contract['items']['id']); $i < $iMax; $i++)
	    		{
		    		$item = Mage::getModel('stalaabo/contract');
		    		$item->setBaseProductId($contract['items']['id'][$i])
		    			->setQty($contract['items']['qty'][$i])
		    			->setCustomerId($contract['customer_id'])
		    			->setShippingAddressId($contract['shipping_adr'])
		    			->setBillingAddressId($contract['billing_adr'])
		    			->setStatus('1')
		    			->setFromDate(Mage::getModel('core/date')->gmtDate(null, $fromDate))
		 				->save();
	    		}
	    	}
	    	else 
	    	{
	    		Mage::throwException($this->__('No valid data given!'));
	    	}
    	}
    	catch (Exception $ex)
    	{
    		Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
    		$this->_redirect('*/*/index');
    		return;
    	}
    	
    	$this->_redirect('*/stalaabo_contract/index');
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