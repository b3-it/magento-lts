<?php
class TuChemnitz_Voucher_Model_Product_Observer extends Varien_Object
{
	
	
	/**
	 * TANs für Tuc voucher importieren
	 *
	 * @param Varien_Object $observer
	 * 
	 * @return void
	 */
	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();
		$tans = array();
		if(isset($_FILES['tucvoucherfilename']['name']) && $_FILES['tucvoucherfilename']['name'] != '') 
		{
			

			/* @var $product Mage_Catalog_Model_Product */
			
			$stockitem = $product->getStockItem();
			
			//nur setzen falls in Lagerverwaltung
			if(!$stockitem->getManageStock())
			{
				Mage::throwException(Mage::helper('tucvoucher')->__("Voucher Product without Inventory not allowed!"));
				return $this;
			}
			
			
			
			$tans = file($_FILES['tucvoucherfilename']['tmp_name']);
		
			$expire = Mage::app()->getRequest()->getPost('tucvoucher_expire');
			if (isset($expire)) {
				$expire= Mage::getModel('core/date')->Date(null, Varien_Date::toTimestamp($expire));
			}
			
			
			$n = 0;
			foreach($tans as $tan)
			{
				$t = Mage::getModel('tucvoucher/tan');
				$t->setTan(trim($tan));
				$t->setProductId($product->getId());
				if($expire){
					$t->setExpire($expire);
				}
				$t->setStatus(TuChemnitz_Voucher_Model_Status::STATUS_NEW);
				$t->setCreatedAt(Mage::getModel('core/date')->gmtdate());
				$t->setUpdatedAt(Mage::getModel('core/date')->gmtdate());
				
				$this->setData('price',0);
				
				$t->save();
				$n++;
			}
			$this->setStockQty($product, $n);
		}
		
		
		return $this;
	}
	
	
	/**
	 * Menge in abhängigkeit der TANs hochsetzen
	 * @param Mage_Catalog_Model_Product $product
	 * @param int $count
	 * @return TuChemnitz_Voucher_Model_Product_Observer
	 */
	private function setStockQty($product,$count)
	{
		
		/* @var $product Mage_Catalog_Model_Product */
		
		$stockitem = $product->getStockItem();
		
		//nur setzen falls in Lagerverwaltung
		if(!$stockitem->getManageStock())
		{
			Mage::log("TuC Voucher:: Voucher Product without Inventory found (ID: " .$product->getId() .")" , Zend_Log::ERR, Egovs_Extstock_Helper_Data::LOG_FILE);
			return $this;
		}
		
		
		
		if(Mage::helper('tucvoucher')->isModuleEnabled('Egovs_Extstock'))	
		{
			$this->saveToExtstock($product,$count);
		}	
		else 
		{
			$stockitem = $product->getStockItem();
			$totalQty = $stockitem->getQty() + $count;
			$stockitem->setData("qty", $totalQty);
			
			$stockitem->save();
		}
		
	}
	
	
	public function allocateTan($observer)
	{
		
		$order = $observer->getEvent()->getOrder();
		foreach ($order->getAllItems() as $item) {
				$n = 0;
				/* @var $item Mage_Sales_Model_Order_Item */
				if ($item->getProductType() == TuChemnitz_Voucher_Model_Product_Type_Tucvoucher::TYPE_VOUCHER
				|| $item->getRealProductType() == TuChemnitz_Voucher_Model_Product_Type_Tucvoucher::TYPE_VOUCHER
				) {
					$collection = Mage::getModel('tucvoucher/tan')->getCollection();
					$collection->getSelect()->where('order_item_id=?',intval($item->getId()));
					
					$n = $item->getQtyOrdered() - count($collection->getItems());
					
					for($i =0; $i < $n; $i++)
					{
						/* @var $model TuChemnitz_Voucher_Model_Tan */ 
						$model= Mage::getModel('tucvoucher/tan');
						$tan = $model->getNextFreeTan($item);
					}
					
				}
		}
		return $n;
	}
	
	
	
	public function sendVoucher($observer)
	{
		try {
			
			//$invoice = $observer->getInvoice();
			
			/* @var  Mage_Sales_Model_Order $order */
			$order = $observer->getOrder();
			$state = $order->getState();
			if(($order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE) 
				|| ($order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING))
			{
				$count = $this->allocateTan($observer);
				
				if($count > 0)
				{
					/* @var TuChemnitz_Voucher_Model_Email $model */
					$model = Mage::getModel('tucvoucher/email');
					$model->sendVoucherEmail($order);
				}
			}
		}
		catch(Exception $ex)
		{
			Mage::logException($ex);
		}
		
		return $this;
	}
	
	protected function saveToExtstock($product,$count)
	{	
		$date = Mage::getModel('core/date')->gmtDate(null);
		$extstock = Mage::getModel('extstock/extstock');
		
		
		$extstock->setData('product_id',$product->getId());
		$extstock->setData('distributor',"TAN Import");
		$extstock->setData('price',0);
		$extstock->setData('date_ordered',$date);
		$extstock->setData('date_delivered',$date);
		$extstock->setData('quantity_ordered',$count);
		$extstock->setData('quantity',$count);
		$extstock->setData('storage',"");
		$extstock->setData('rack',"");
		$extstock->setData('status',Egovs_Extstock_Helper_Data::DELIVERED); 
		
		$extstock->save();	
		
		
		
		
		return $this;
	}
    
}