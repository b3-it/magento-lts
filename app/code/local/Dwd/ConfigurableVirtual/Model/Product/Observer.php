<?php
class Dwd_ConfigurableVirtual_Model_Product_Observer extends Varien_Object
{
	private $_station = null;
	
	
	/**
	 * Daten für Configurable Virtual für spätere Bearbeitung setzen
	 *
	 * @param Varien_Object $observer
	 * 
	 * @return void
	 */
	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();
		
		if ($configvirtual = $request->getPost('configvirtual')) {
			$product->setConfigvirtualData($configvirtual);
		}
		
		
	}
	
	public function prepareProductEdit($observer) {
		/* @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		if (!$product || $product->getTypeId() != Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL) {
			return;
		}
		
		$product->getTypeInstance()->limitMaxSaleQty($product);
	}
	
	
	public function onSalesQuoteItemSetProduct($observer)
	{
		/* @var $orderItem Mage_Sales_Model_Quote_Item  */ 
		$orderItem = $observer->getQuoteItem();
		$product = $observer->getProduct();
	 	if ($product && $product->getTypeId() != Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL) {
            return $this;
        }
        
        $specialPrice = -1000;
        
	    $station_id = $orderItem->getOptionByCode('station_id');
	    if($station_id)
	    {
	    	$orderItem->setStationId($station_id->getValue());
	    }
        
	    $periode_id = $orderItem->getOptionByCode('periode_id');
	    if($periode_id)
	    {
	    	$periode_id = $periode_id->getValue();
	    	
	        $orderItem->setPeriodId($periode_id);
	        
	        $customer_id = null;
	        if($orderItem->getQuote()){
	        	$customer_id = $orderItem->getQuote()->getCustomerId();
	        }
	        
	    	$periode = Mage::getModel('periode/periode')->load($periode_id);
		    	if($periode->getId() == 0)
		    	{
		    		Mage::throwException('Periode not found');
		    	}
		    	
		    	$orderItem->addOption(array('code'=>'period_object','value'=>serialize($periode)));
		    	
		    	//Prüfen ob automatische Aboverlängerung:
		    	$aboItem = $orderItem->getAboItem();
		    	if($aboItem)
		    	{
		    		$q = $aboItem->getTierPriceDependBenefitCount();
		    		$tp = $periode->getTierPriceForQty($q+1);
		    		if($tp){
		    			$specialPrice = $tp->getPrice();
		    		}
		    		else{
		    			$specialPrice = $periode->getPrice() + $product->getPrice();
		    		}
		    	}
		    	else if($tp = $periode->getCustomerTierPrice($customer_id)){
		    		$specialPrice = $tp->getPrice();
		    		$br = $orderItem->getOptionByCode('info_buyRequest');
		    		if(!$br)
		    		{
		    			$orderItem->addOption(array('code'=>'info_buyRequest','value'=>serialize(array())));
		    			$br = $orderItem->getOptionByCode('info_buyRequest');
		    		}
		    		if($br){
		    			$options = unserialize($br->getValue());
		    		
		    			$options['has_periode_tier_price'] = true;
		    			$options['periode_tier_price_depends'] = $tp->getPriceDepentsOn();
		    			//$orderItem->addOption(array('code'=>'info_buyRequest','value'=>true));
		    			$br->setValue(serialize($options));
		    		}
		    				    		
		    	}else{
		    		$specialPrice = $periode->getPrice() + $product->getPrice();
		    	}
		
			    // Make sure we don't have a negative
			    if ($specialPrice > 0) {
			        $orderItem->setCustomPrice($specialPrice);
			        $orderItem->setOriginalCustomPrice($specialPrice);
			        $orderItem->getProduct()->setIsSuperMode(true);
			    }
	     
	    }
	}
	
	
	public function onSalesOrderSaveAfter($observer) {
		/* @var $order Mage_Sales_Model_Order */
		$order = $observer->getOrder();
	
		
		if (!$order || $order->isEmpty()) {
			return;
		}
	
		
		$state = $order->getState();
		if(($state != Mage_Sales_Model_Order::STATE_COMPLETE) && ($state != Mage_Sales_Model_Order::STATE_PROCESSING))
		{
			return;
		}
		
		
		//nur bei Status änderung weitermachen
		$origState = 'dummy';
		if(count($order->getOrigData()) > 0)
		{
			$orig = $order->getOrigData();
			$origState = $orig['state'];
		}
		
		if(($origState == Mage_Sales_Model_Order::STATE_COMPLETE) && ($origState == Mage_Sales_Model_Order::STATE_PROCESSING))
		{
			return;
		}
		
		
		foreach($order->getAllItems() as $orderitem)
		{
			/* @var $orderitem Mage_Sales_Model_Order_Item */
			if(count($orderitem->getChildrenItems()) > 0){
				continue;
			}
			$this->processOrderItem($orderitem, $order);
		}
		
		
		
	}
	
	public function processOrderItem($orderitem, $order)
	{
		if (!$orderitem->getId()) {
			//order not saved in the database
			return $this;
		}
		$product = $orderitem->getProduct();			
		
		if (!$product) {
			$product = Mage::getModel('catalog/product')
			->setStoreId($order->getStoreId())
			->load($orderitem->getProductId());
		} else {
			$product = Mage::getModel('catalog/product')->load($product->getId());
		}
		if ($product && $product->getTypeId() != Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL) {
			return $this;
		}
		
		if(Mage::helper('configvirtual')->isModuleEnabled('Dwd_Icd') && ($product->getIcdUse() == 1))
		{
			$this->save4Icd($orderitem, $order, $product);
		}
		else
		{
			$this->saveCredentials($orderitem,$order, $product);
		}
		
		 
		 
		return $this;
	}
	
	/*
    public function saveOrderItem($observer)
    {
    	
    	//TODO: HK wird diese Funktion gebraucht?	
    	$orderItem = $observer->getEvent()->getItem();
        if (!$orderItem->getId()) {
            //order not saved in the database
            return $this;
        }
        $product = $orderItem->getProduct();
        
        $order = $orderItem->getOrder();
        $state = $order->getState();
      
        
        if (!$product) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId($order->getStoreId())
                ->load($orderItem->getProductId());
        } else {
        	$product = Mage::getModel('catalog/product')->load($product->getId());
        }
        if ($product && $product->getTypeId() != Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL) {
        	return $this;
        }
        
        if(Mage::helper('configvirtual')->isModuleEnabled('Dwd_Icd'))
        {
        	if (($product->getIcdUse() == null) || ($product->getIcdUse() == 1))
        	{
        		$this->save4Icd($orderItem, $order, $product);
        	}else {
        		$this->saveCredentials($orderItem,$order, $product);
        	}
        }
        else 
        {
        	$this->saveCredentials($orderItem,$order, $product);
        }
       	
       
       
       return $this;
    }
    */
    
    public function onBeforeSaveOrderItem($observer)
    {
    	$orderItem = $observer->getItem();
    	if($orderItem->getProductType() != Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL)
    	{
    		return $this;
    	}
    	$options = $orderItem->getBuyRequest();
    	
    	if($options->getPeriode())
    	{
    		$periode = Mage::getModel('periode/periode')->load($options->getPeriode());
    		if($periode->getId())
    		{
    			$orderItem->setPeriodType($periode->getType());
    			$orderItem->setPeriodStart($periode->getStartDate());
    			$orderItem->setPeriodEnd($periode->getEndDate());
    			$orderItem->setPeriodId($periode->getId());
    			
    			
    		}
    	}
    	if($options->getStation())
    	{
    		$orderItem->setStationId($options->getStation());
    	}
    	
    	
    }
    
    
    /***
     * Daten an ICd übergeben
     */
    protected function save4Icd($orderItem, $order, $product)
    {
    	//Abfrage wg. doppeltem Aufruf bei Kreditkarte
    	$purchasedItem = Mage::getModel('dwd_icd/orderitem')->load($orderItem->getId(),'order_item_id');
    	if($purchasedItem->getId()) return $this;
    		
    	
    	$cat = $product->getCategoryIds();
    	if(is_array($cat) && (count($cat)>0))
    	{
    		$cat = $cat[0];
    	}
    	else
    	{
    		$cat = 0;
    	}  	
    	
    	$account = Dwd_Icd_Model_Account::loadOrCreate($order->getCustomerId(),!$product->getData('always_create_new_credentials'),$order->getCustomerEmail(),$product->getData('icd_connection'));

  	
    	if(!$orderItem->getPeriodEnd() )
    	{
    		
    		$p = Dwd_Periode_Model_Periode::getNewOneDayDuration(1);
    		$orderItem->setPeriodStart($p->getStartDate());
    		$orderItem->setPeriodEnd($p->getEndDate());
    	}
    	
    	
    	
    	$purchasedItem = Mage::getModel('dwd_icd/orderitem');
    	$purchasedItem//->setPurchasedId($purchased->getId())
    	->setOrderItemId($orderItem->getId())
    	->setOrderId($order->getId())
    	->setProductId($product->getId())
    	->setApplication($product->getIcdApplication())
    	->setApplicationUrl($product->getConfigvirtualBaseUrl())
    	->setStationId($orderItem->getStationId())
    	->setAccountId($account->getId())
    	->setCreatedTime(now())
    	->setUpdateTime(now())
    	->setStartTime($orderItem->getPeriodStart())
    	->setEndTime($orderItem->getPeriodEnd())
    	->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEW)
    	->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING)
    	->save();
    	/*
    	try
    	{
    		$this->sendMailToBearbeiter($product,$cat,$purchasedItem);
    	}
    	catch (Exception $ex)
    	{
    		Mage::log($ex, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    	}
    	*/
    }
    
    
    
    protected function saveCredentials($orderItem, $order, $product)
    {
  			//Abfrage wg. doppeltem Aufruf bei Kreditkarte
  			$purchasedItem = Mage::getModel('configvirtual/purchased_item')->load($orderItem->getId(),'order_item_id');
 			if($purchasedItem->getId()) return $this;
  			
	        $purchased = Mage::getModel('configvirtual/purchased')->load($order->getId(),'order_id');
	        if($purchased->getId() == 0)
	        {
	        	$purchased->setOrderId($order->getId())
	        				->setOrderIncrementId($order->getIncrementId())
	        				->setCreatedAt(now())
							->setUpdatedAt(now())
							->setCustomerId($order->getCustomerId())
							//->setProduct
							->save();
							;
	        }
	        
	        $credential = $this->getCredential($order->getCustomerId(),!$product->getData('always_create_new_credentials'),$order->getCustomerEmail());
	         
	         
	         $cat = $product->getCategoryIds();
	         if(is_array($cat) && (count($cat)>0))
	         {
	         	$cat = $cat[0];
	         }
	         else
	         {
	         	$cat = 0;
	         }
	         $purchasedItem = Mage::getModel('configvirtual/purchased_item');
	         $purchasedItem->setPurchasedId($purchased->getId())
	         			   ->setOrderItemId($orderItem->getId())
	         			   ->setProductId($product->getId())
	         			   ->setExternalLinkUrl($product->getData('configvirtual_base_url'))
	         			   ->setStationId($orderItem->getStationId())
	         			   ->setCredentialId($credential->getId())
	         			   ->setCreatedAt(now())
						   ->setUpdatedAt(now())
						   ->setCategoryId($cat)
	         			   ->setValidUntil($orderItem->getPeriodEnd()) //tage
	         			   ->save();
	        try 
	        {
	        	$this->sendMailToBearbeiter($product,$cat,$purchasedItem);
	        }
	        catch (Exception $ex)
	        {
	        	Mage::logException($ex);
	        	Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
	        }
			
    }
    
    private function getCredential($customerId, $is_shareable, $email)
    {
    	$credential = null;
    	if(($customerId != 0) && ($is_shareable))
    	{
    		$collection = Mage::getModel('configvirtual/purchased_credential')->getCollection();
    		$collection->getSelect()->where('customer_id = '.$customerId)
    								->where('is_shareable = 1')
    								->limit('1');
    		foreach ($collection->getItems() as $item)
    		{
    			$credential = $item;
    			break;
    		}
    		
    	}
    	
    	if ($credential == null)
    	{
    			$credential = Mage::getModel('configvirtual/purchased_credential');
    			if(!$is_shareable)
    			{
    				$credential->setUsername(Mage::helper('core')->getRandomString(8));
    			}
    			else 
    			{
    				$credential->setUsername($email);
    			}
    			$credential->setIsShareable($is_shareable)
    						->setCustomerId($customerId)
    						->setPassword(Mage::helper('core')->getRandomString(10))
    						->setCreatedAt(now())
							->setUpdatedAt(now())
							->save();
    	}
    	
    	return $credential;
    }
	
    
    
    public function sendMailToBearbeiter($product, $category, $purchase_item) {

    	$p = Mage::getModel('catalog/product')->load($product->getId());
   		
   		$customerEMail = mb_ereg_replace(' ', '', $p->getBearbeiterEmail());
   		if (strlen($customerEMail) < 1) {
   			return;
   		}
   		$customerEMail = explode(';', $customerEMail);
   		
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        $template = Mage::getStoreConfig("configvirtual/email/owner_template", $this->getStoreId());
        $customerName = null;// $this->getCustomerName();
        
        
        $data = array();
		$data['product_name'] = $product->getName();
		$data['product_sku'] = $product->getSku();
		$data['category'] = $category;
		$data['link'] = Mage::helper("adminhtml")->getUrl('*/configvirtual_credential/index',array('item_id'=>$purchase_item->getId()));
		$data['item_id'] = $purchase_item->getId();
	       
        
        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()))
                ->sendTransactional(
                    $template,
                    'configvirtual',
                    $customerEMail,
                    $customerName,
                   	$data
                );
        

        $translate->setTranslateInline(true);

        return $this;   		
    }
    
 
    
    public function getStoreId()
    {
          return Mage::app()->getStore()->getId();
    }
 
    
    
}