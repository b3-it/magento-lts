<?php

class Stala_Abo_Adminhtml_Stalaabo_DeliverpostController extends Egovs_Base_Controller_Adminhtml_Abstract
{

	private $_stockTotalQty = null;
	private $SHIPPINGMETHOD = 'freeshipping';
	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('deliver/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_deliverpost'))
			->renderLayout();
	}

    public function gridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('stalaabo/adminhtml_deliver_grid')->toHtml());
    }
 
	
    
    public function createLabelAction()
    {
        $deliverIds = $this->getRequest()->getParam('deliver_id');
        $deliverIds = explode(',', $deliverIds);
        if(!is_array($deliverIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } 
        else 
        {
            try {
				$deliverIds = implode(',',$deliverIds);
            	$collection = Mage::getModel('stalaabo/deliver')->getCollection();
            	$collection->orderByShippmentAddress();    	
            	$collection->getSelect()->where('abo_deliver_id IN('. $deliverIds .') AND shipping_qty < contract_qty');
            	
            	$abo_shipment = null;
            	$lastAdrId = -1;
            	$abo_shipments = array();
            	
            	foreach($collection->getItems() as $item)
            	{
            		//falls sich die Adresse ge�ndert hat neue Lieferung
            		if($item->getShippingAddressId() != $lastAdrId)
            		{
            			$lastAdrId = $item->getShippingAddressId();
            			$adr = Mage::getModel('customer/address')->load($item->getShippingAddressId());
            			$address = Mage::getModel('sales/order_address');
            			Mage::helper('core')->copyFieldset('sales_convert_order_address', 'to_quote_address', $adr, $address);
            			$address->save();
            			$abo_shipments[] = $address;
            		}
            	}
            	
            	$pdf = Mage::getModel('egovsbase/sales_order_pdf_addresslabel')->getPdf(array($abo_shipments));
	           	
            	return $this->_prepareDownloadResponse('addresslabel'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
	            
            }
            catch (Exception $ex)
            {
            	 $this->_getSession()->addError($ex->getMessage());
            }
        }
       // $this->_redirect('*/*/index');
    }
	
	/*
	 * Lieferschein Drucken
	 */
	public function createShippingAction()
    {
    	$this->_stockTotalQty = array();
        $deliverIds = $this->getRequest()->getParam('deliver_id');
        if(!is_array(explode(',',$deliverIds))) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else 
        {
            try {
				$abo_shipments = $this->collectShippments($deliverIds);
	            $pdf = Mage::getModel('sales/order_pdf_shipment')->getPdf($abo_shipments);
	         
         	if (count($abo_shipments) > 0) {
         		return $this->_prepareDownloadResponse('packingslip'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
            } else {
                $this->_getSession()->addError($this->__('There are no printable documents related to selected orders'));
                $this->_redirect('*/*/');
            }
            
         	} 
         	catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
         $this->_redirect('*/*/index');
    }
    
    
    //Mengen setzen
	public function finishShippingAction()
    {
    	$this->_stockTotalQty = array();
        $deliverIds = $this->getRequest()->getParam('deliver_id');
        $deliverIds = explode(',',$deliverIds);
         if(!is_array($deliverIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else 
        {
            try {
            	$aboModel = Mage::getModel('stalaabo/shipping');
            	$aboModel->setDeliverIds($deliverIds)
            			 ->finishShipping();
            	
				
            
         	} 
         	catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
         $this->_redirect('*/stalaabo_deliver/');
    }
	
    private function processFreeCopies($deliverIds)
    {
    //freecopies 'reservieren'
    	$collection = Mage::getModel('stalaabo/deliver')->getCollection();
    	$collection->getSelect()
    			->where('abo_deliver_id in ('.$deliverIds.')');
    	$collection->load();
	    	foreach ($collection->getItems() as $item)
	    	{
	    		$freecopy = Mage::getModel('extcustomer/freecopies');
	    		
	    		$res = $freecopy->decreaseFreecopies($item->getContractQty(),$item->getProductId(),$item->getCustomerId());
	    		
	    		if(($res != null) && (count($res) > 0))
	    		{
	    			$item->setFreecopies(serialize($res));
	    			$item->save();
	    		}
	    	}
    }
    
    
    private function collectShippments($deliverIds)
    {
			
            $collection = Mage::getModel('stalaabo/deliver')->getCollection();
            $collection->orderByShippmentAddress();            	
            $collection->getSelect()->where('abo_deliver_id IN('. $deliverIds .') AND shipping_qty < contract_qty');
            $collection->getSelect()->order('product_id');
            
 //die($collection->getSelect()->__toString());           
            $abo_shipment = null;
            $lastAdrId = -1;
            $abo_shipments = array();
            
    		$owner = Mage::getSingleton('admin/session')->getUser();
			
         
            foreach($collection->getItems() as $item)
            {
            	//falls sich die Adresse ge�ndert hat neue Lieferung
            	if($item->getShippingAddressId() != $lastAdrId)
            	{
            		$abo_shipment = $this->getShippment($item);
            		$abo_shipment->getOrder()->setOwner($owner->getName());
					$abo_shipment->getOrder()->setOwnerPhone($owner->getPhone());
            		$lastAdrId = $item->getShippingAddressId();
            		$abo_shipments[] = $abo_shipment;
            	}
            	else
            	{
            		$this->addItemToShippment($abo_shipment,$item);
            		
            	}
            }
            
            return $abo_shipments;
    }
 
    private function getShippment($item)
    {
  	
    	$obj = new Varien_Object();
    	$obj->setStoreId(0);
    	$obj->setCreatedAtStoreDate(new Zend_Date());
    	$obj->setCreatedAt(new Zend_Date());
    	
    	$order = Mage::getModel('sales/order');
    	$adr = Mage::getModel('customer/address')->load($item->getShippingAddressId());
    	$adr->setCustomerId($item->getCustomerId());
    	if(($adr == null) || ($adr->getId()== 0))
    	{
    		Mage::throwException("Adress not found");
    	}
    	
    	$adr = Mage::getModel('sales/order_address')->addData($adr->getData()); 
    	//die OrderAdresse darf noch nicht gespeichert sein?? 
    	$adr->unsetData('entity_id');
    	
    	$obj->setShippingAddress($adr);
    	$order->setShippingAddress($adr);
    	
    	
    	$billadr = Mage::getModel('customer/address')->load($item->getBillingAddressId());
    	$obj->setBillingAddress($billadr);
    	//$order->setBillingAddress($billadr);
    	
    	
    	$order->setCreatedAt(new Zend_Date());
    	
		$order->setCustomerId($item->getCustomerId());
    	
    	$order->setShippingDescription(Mage::getStoreConfig('carriers/'.$this->SHIPPINGMETHOD.'/title') . ' - ' . Mage::getStoreConfig('carriers/'.$this->SHIPPINGMETHOD.'/name') );
    	$obj->setShippingDescription(Mage::getStoreConfig('carriers/'.$this->SHIPPINGMETHOD.'/title') . ' - ' . Mage::getStoreConfig('carriers/'.$this->SHIPPINGMETHOD.'/name') );
    	   	
    	$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
    	$order->setPrintnote1($customer->getAboPrintNote1());
        $order->setPrintnote2($customer->getAboPrintNote2());
        $order->setCustomerGroupId($customer->getGroupId());
    	$obj->setOrder($order);
    	
    	$this->addItemToShippment($obj,$item);
    	return $obj;
    }

  	private function addItemToShippment($abo_shipment,$contractitem)
  	{
  		$product = Mage::getModel('catalog/product')->load($contractitem->getProductId());
  		$stock = $product->getStockItem();
  		
  		
  		if(isset($this->_stockTotalQty[$product->getId()]))
  		{
  			$this->_stockTotalQty[$product->getId()] += $contractitem->getQty();
  		}
  		else 
  		{
  			$this->_stockTotalQty[$product->getId()] = $contractitem->getQty();
  		}
  		
  		
  		if(($stock->getManageStock()) && ($stock->getQty() - $this->_stockTotalQty[$product->getId()] < 0))
  		{
  			$txt = Mage::helper('stalaabo')->__('Action canceled! Product is out of stock!');
  			Mage::throwException($txt.'(ID: '.$product->getId().')');
  		}
        $item = Mage::getModel('sales/order_item');
		$item->setQty($contractitem->getQty());
		$item->setSku($product->getSku());
		$item->setName($product->getName());
		$item->setOrderItem($product);
		$item->setProductId($product->getId());
		$item->setCatalogPrice($product->getPrice());
		
		$allItems = $abo_shipment->getAllItems();
		if($allItems == null)
		{
			$allItems = array();
		}
		$allItems[] = $item;
		$abo_shipment->setAllItems($allItems);
		
		return $this;
  	}   

  	protected function _isAllowed() {
  		$action = strtolower($this->getRequest()->getActionName());
  		switch ($action) {
  			default:
  				return Mage::getSingleton('admin/session')->isAllowed('stalaabo/deliver');
  				break;
  		}
  	}
 
}