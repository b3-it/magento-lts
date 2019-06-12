<?php

class Slpb_Verteiler_Adminhtml_Slpbverteiler_OrderController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sales/verteiler')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Verteiler'), Mage::helper('adminhtml')->__('Verteiler'));
		
		return $this;
	}  
	
	public function indexAction() 
	{
		$this->_getSelectedItems();
    	//$customer_id = $contract->getCustomerId();
    	//if($customer_id)
    	{	
			$this->_initAction()
				->_addContent($this->getLayout()->createBlock('verteiler/adminhtml_order_create'))
				->renderLayout();
    	}
    	//else
    	{
    		//$this->_redirect('*/*/customer');
    	}
	}
	
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('verteiler/adminhtml_order_create_product_grid')->toHtml()
		);
	}
	
    private function _getSelectedItems()
    {
    	$res = Mage::getSingleton('adminhtml/session')->getData('verteiler_order_create');
    	if($res == null)
    	{
    		$res = Mage::getModel('verteiler/order_create');
    		Mage::getSingleton('adminhtml/session')->setData('verteiler_order_create',$res);
    	}
    	
    	return $res;
    }
    
    public function addItemsAction()
    {
    	$contract = $this->_getSelectedItems();
    	$id = $this->getRequest()->getParam('id');
    	$contract->addItem($id);
    	$this->itemsListAction();
    }
    
   	public function changeItemsAction()
    {
    	$contract = $this->_getSelectedItems();
    	$id = $this->getRequest()->getParam('id');
    	$qty = $this->getRequest()->getParam('qty');
    	$contract->changeItem($id,$qty);
    	$this->itemsListAction();
    }
    
    public function removeItemsAction()
    {
    	$contract = $this->_getSelectedItems();
    	$id = $this->getRequest()->getParam('id');
    	$contract->removeItem($id);
    	$this->itemsListAction();
    }
	
    public function itemsListAction()
    {
    	$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('verteiler/adminhtml_order_create_list')->toHtml());
    }
    
    public function createPostAction()
    {
    	$contract = $this->getRequest()->getPost('create_order');
    	$verteiler_id = $contract['verteiler'];
    	try 
    	{
	    	if($contract != null)
	    	{
	    		if((!isset($contract['items'])) || ($contract['items']== null) ||(count($contract['items']['id']) == 0))
	    		{
	    			Mage::throwException($this->__('Enter Products, please!'));
	    		}
	    		
	    		$products = array();
	    		for($i = 0; $i < count($contract['items']['id']); $i++)
	    		{
		    		$id = $contract['items']['id'][$i];
		    		$qty = $contract['items']['qty'][$i];	
		    		$products[] = array('id'=>$id,'qty'=>$qty);	
	    		}
	    		
	    		$orders = Mage::getModel('verteiler/order');
	    		$note = array();
	    		$note[] = $contract['note1'];
	    		$note[] = $contract['note2'];
	    		$orders->createOrders($verteiler_id,$products, $note);
	    		Mage::getSingleton('adminhtml/session')->unsetData('verteiler_order_create');
	    		Mage::getSingleton('adminhtml/session')->addSuccess('Die Bestellung wurde angelegt');

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
    	
    	$this->_redirect('*/*/index');
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('slpb_verteiler');
    			break;
    	}
    }
	
}