<?php
class Bkg_VirtualAccess_Model_Product_Observer extends Varien_Object
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

		if ($virtualaccess = $request->getPost('virtualaccess')) {
			$product->setConfigvirtualData($virtualaccess);
		}


	}

	public function prepareProductEdit($observer) {
		/* @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		if (!$product || $product->getTypeId() != Bkg_VirtualAccess_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_ACCESS) {
			return;
		}

		$product->getTypeInstance()->limitMaxSaleQty($product);
	}





	public function onSalesOrderSaveAfter($observer) {
		/* @var $order Mage_Sales_Model_Order */
		$order = $observer->getOrder();


		if (!$order || $order->isEmpty()) {
			return;
		}


		$state = $order->getState();
		if(($state != Mage_Sales_Model_Order::STATE_COMPLETE)
				&& ($state != Mage_Sales_Model_Order::STATE_PROCESSING)
				&& ($state != Mage_Sales_Model_Order::STATE_CANCELED)
				&& ($state != Mage_Sales_Model_Order::STATE_CLOSED))
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


		$this->setLog('onSalesOrderSaveAfter: ID=' .$order->getId(). ', state='. $state .', origState='.$origState);

		//falls keine Änderung -> keine Aktion
		if($origState == $state)
		{
			return;
		}

		//hier den Fall Stornierung abhandeln
		if((($origState != Mage_Sales_Model_Order::STATE_CANCELED)|| ($origState != Mage_Sales_Model_Order::STATE_CLOSED)) &&
			(($state == Mage_Sales_Model_Order::STATE_CANCELED)  || ($state == Mage_Sales_Model_Order::STATE_CLOSED)))
		{

			$this->_cancelOrderItems($order->getAllItems());
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
		if ($product && $product->getTypeId() != Bkg_VirtualAccess_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_ACCESS) {
			return $this;
		}

		$this->saveCredentials($orderitem,$order, $product);




		return $this;
	}

	/**
	 * Stornierung von CVP Produkten - Statusänderung in ICD
	 * @param Mage_Sales_Model_Order_Item $orderItems
	 */
	public function _cancelOrderItems($orderItems)
	{
		if(count($orderItems) == 0) { return; }
		foreach($orderItems as $orderItem)
		{
			/* @var $orderitem Mage_Sales_Model_Order_Item */
			if(count($orderItem->getChildrenItems()) > 0){
				continue;
			}
			if($orderItem->getProductType() != Bkg_VirtualAccess_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_ACCESS){
				continue;
			}

			//Zugang via ICD schließen
			$purchasedItem = Mage::getModel('dwd_icd/orderitem')->load($orderItem->getId(),'order_item_id');
			if($purchasedItem->getId() > 0)
			{
				//
				if(($purchasedItem->getStatus() == Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)&&
					($purchasedItem->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS))
				{
					$purchasedItem
					->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DISABLED)
					->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING)
					->save();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualaccess')->__('ICD has been informed removing credetials!'));
				}
				else
				{
					
					Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('virtualaccess')->__('Item %s could not canceld within ICD (Id: %s) Status %s Sync %s.',
							$orderItem->getName(), 
							$purchasedItem->getId(),
							Dwd_Icd_Model_OrderStatus::getLabel($purchasedItem->getStatus()),
							Dwd_Icd_Model_OrderStatus::getLabel($purchasedItem->getSyncStatus())
									));
				}
			}


			if($orderItem->getPeriodType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO)
			{
				$abo = Mage::getModel('dwd_abo/abo')->load($orderItem->getId(),'current_orderitem_id');
				if($abo->getId() > 0)
				{
					$abo->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_PAUSE)
						->setStatus(Dwd_Abo_Model_Status::STATUS_DELETE)
						->save();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualaccess')->__('Subscription has ben closed!'));
					$firstOrderID = $abo->getFirstOrderId();
					if($firstOrderID)
					{
						$collection = Mage::getModel('dwd_abo/abo')->getCollection();
						$collection->getSelect()
							->where('first_order_id = ?', intval($firstOrderID))
							->where('current_orderitem_id > ? ', $orderItem->getId());

						if(count($collection->getItems()) > 0 )
						{
							foreach($collection->getItems() as $item){
								//Der Zugang wird zum Laufzeitende des Abonnements (09.05.2016) automatisch entfernt (#Angabe des Produkts#)“).
								Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('virtualaccess')->__("Der Zugang wird zum Laufzeitende des Abonnements (%s) automatisch entfernt (%s)."
										,Mage::app()->getLocale()->date($item->getStopDate(), null, null, true),
										$orderItem->getName()));
							}
						}
					}
				}

			}
		}
	}

    public function onBeforeSaveOrderItem($observer)
    {
    	$orderItem = $observer->getItem();
    	if($orderItem->getProductType() != Bkg_VirtualAccess_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_ACCESS)
    	{
    		return $this;
    	}
    	$options = $orderItem->getBuyRequest();

    	if(!$orderItem->getPeriodId())
    	{
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
    	}
    	if($options->getStation())
    	{
    		$orderItem->setStationId($options->getStation());
    	}


    }






    protected function saveCredentials($orderItem, $order, $product)
    {
  			//Abfrage wg. doppeltem Aufruf bei Kreditkarte
  			$purchasedItem = Mage::getModel('virtualaccess/purchased_item')->load($orderItem->getId(),'order_item_id');
 			if($purchasedItem->getId()) return $this;

	        $purchased = Mage::getModel('virtualaccess/purchased')->load($order->getId(),'order_id');
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




	         $purchasedItem = Mage::getModel('virtualaccess/purchased_item');
	         $purchasedItem->setPurchasedId($purchased->getId())
	         			   ->setOrderItemId($orderItem->getId())
	         			   ->setProductId($product->getId())
	         			   ->setExternalLinkUrl($product->getData('virtualaccess_base_url'))
	         			   ->setCreatedAt(now())
						   ->setUpdatedAt(now())
	         			   ->save();

        $credential = $this->getCredential($order->getCustomerId(),$purchasedItem,$order->getCustomerEmail());


    }

    private function getCredential($customerId, $purchasedItem, $email)
    {

    			$credential = Mage::getModel('virtualaccess/purchased_credential');
    			$credential->setUsername($email);

    			$credential	->setCustomerId($customerId)
    						->createUuid()
    						->setCreatedAt(now())
							->setUpdatedAt(now())
                            ->setPurchasedItemId($purchasedItem->getId())
							->save();


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

        $template = Mage::getStoreConfig("virtualaccess/email/owner_template", $this->getStoreId());
        $customerName = null;// $this->getCustomerName();


        $data = array();
		$data['product_name'] = $product->getName();
		$data['product_sku'] = $product->getSku();
		$data['category'] = $category;
		$data['link'] = Mage::helper("adminhtml")->getUrl('adminhtml/virtualaccess_credential/index',array('item_id'=>$purchase_item->getId()));
		$data['item_id'] = $purchase_item->getId();


        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()))
                ->sendTransactional(
                    $template,
                    'virtualaccess',
                    $customerEMail,
                    $customerName,
                   	$data
                );


        $translate->setTranslateInline(true);

        return $this;
    }



    public function getStoreId($item = null)
    {
    	
    	if($item instanceof Mage_Sales_Model_Quote_Item){
    		return $item->getQuote()->getStoreId();
    	}
    	
    	if($item instanceof Mage_Sales_Model_Order_Item){
    		return $item->getOrder()->getStoreId();
    	}
    	
    	return Mage::app()->getStore()->getId();
    }



}