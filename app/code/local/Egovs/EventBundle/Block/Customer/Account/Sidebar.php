<?php
/**
 * 
 *  Anzeige der noch nicht gebuchten Optionen im Benutrzerkontext 
 *  @category Egovs
 *  @package  Egovs_EventBundle
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Block_Customer_Account_Sidebar extends Mage_Core_Block_Template
{
 
	private $_Customer = null;
	private $_SoldEventBundleProducts = null;
	private $_AvailableProducts = null;
	
	/**
	 * die Url zum Hinzufügen des einele Produktes zum Warenkorb
	 * @param Mage_Bundle_Model_Resource_Bundle $product
	 * @param array $additional
	 */
	public function getAddToCartUrl($product, $additional = array())
	{
		if ($product->getTypeInstance(true)->hasRequiredOptions($product)) {
			if (!isset($additional['_escape'])) {
				$additional['_escape'] = true;
			}
			if (!isset($additional['_query'])) {
				$additional['_query'] = array();
			}
			$additional['_query']['options'] = 'cart';
	
			return $this->getProductUrl($product, $additional);
		}
		return $this->helper('checkout/cart')->getAddUrl($product, $additional);
	}

	/**
	 * Kunden aus der Session ermitteln
	 */
	protected function getCustomer()
	{
		if ($this->_Customer === null) {
			$this->_Customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_Customer;
	}
	
	
	/**
	 * Alle gekauften und verfügbaren EventBundle-Produkte des Kunden ermitteln
	 */
	protected function getSoldEventBundleProducts()
	{
		if($this->_SoldEventBundleProducts == null)
		{
			$customer = $this->getCustomer();
			
			$eav = Mage::getResourceModel('eav/entity_attribute');		
			$collection = Mage::getModel('sales/order_item')->getCollection();
		
			$collection->getSelect()
				->distinct()
				->join(array('order'=>$collection->getTable('sales/order')), "order.entity_id= main_table.order_id AND customer_id = " . $this->getCustomer()->getId(),array())
				->join(array('product_status'=>Mage::getConfig()->getTablePrefix().'catalog_product_entity_int'),'product_status.entity_id=main_table.product_id AND value=1 AND product_status.attribute_id='.$eav->getIdByCode('catalog_product', 'status'),array())
				->where("product_type='eventbundle'")
				->where("order.status IN ('processing','complete')");

			//die($collection->getSelect()->__toString());
			
			$this->_SoldEventBundleProducts = $collection->getItems();
		}
		return $this->_SoldEventBundleProducts;
	}
	
	/**
	 * Verschneiden einzelner Käufe sowohl von EventBundle als auch von Teilartikeln
	 * @return multitype:Ambigous <Mage_Core_Model_Abstract, Mage_Core_Model_Abstract>
	 */
	public function getAvailableProducts()
	{
		if($this->_AvailableProducts == null)
		{
			$soldProducts = $this->getSoldEventBundleProducts();
			$products = array();
			
			/* @var $sold Mage_Sales_Model_Order_Item */
			foreach($soldProducts as $sold)
			{
				if((!$sold->getStoreId()) || ($sold->getStoreId() == Mage::app()->getStore()->getId()))
				{
					$soldOption = $sold->getProductOptionByCode("bundle_options");
					
					if(!isset($products[$sold->getProductId()]))
					{
						$p = Mage::getModel('catalog/product')->load($sold->getProductId());
						$p->setProductOptions($this->getProductOptions($p));
						$soldOptions = array();
						$orderItems = array();
						$products[$sold->getProductId()] = $p;
						$p->setSoldProductCount(0);
					}
					else 
					{
						$p = $products[$sold->getProductId()];
						$soldOptions = $p->getSoldOptions();
						$orderItems = $p->getOrderItems();
						
					}
					$orderItems[] = $sold->getItemId();
					$soldOptions[] = $soldOption;
					$p->setSoldOptions($soldOptions);
					$p->setOrderItems($orderItems);
					$p->setSoldProductCount($p->getSoldProductCount()+$sold->getQtyToShip());
				}
			}
			
			//Produkte aus anderen Verkäufen oder Warenkorb entfernen
			foreach($products as $product)
			{
				$this->removeSoldOptions($product);
				$this->removeCardOptions($product);
				$this->removeSoldSelections($product);
				$this->removeCardSelections($product);
				$this->removeNotAvailable($product);
			}
			
			$this->_AvailableProducts = $products;
		}
		return $this->_AvailableProducts;
	}
	
	
	/**
	 * 
	 * entfernen der bereits gekauften Optionen
	 * @param Mage_Bundle_Model_Resource_Bundle $product
	 */
	protected function removeSoldOptions($product)
	{
		$options = $product->getProductOptions();
		
		//erstmal die Optionen entfernen die gleich mit gekauft wurden
		foreach($options as $option)
		{
			if(($option->getType() == 'checkbox') || ($option->getType() == 'multiselect')){
				continue;
			}
				
			$soldOptions = $product->getSoldOptions();
			$found = array();
			foreach($soldOptions as $sold)
			{
				$id = $option->getOptionId();
				
				if(!isset($found[$id]))
				{
					$found[$id] = 0;
				}
				
				if(isset($sold[$id]))
				{
					$found[$id] += 1;
				}
			}
			
			foreach($soldOptions as $sold)
			{
				$id = $option->getOptionId();
				if($found[$id] == count($soldOptions))
				{
					if(isset($options[$id]))
					{
						unset($options[$id]);
					}
				}
			}
		}
		
		//alle nachträglich gekauften Produkte finden
		foreach($options as $option)
		{
			if(($option->getType() == 'checkbox') || ($option->getType() == 'multiselect')){
				continue;
			}
			
			$productIds = array();
			if($option->getSelections())
			{
				foreach($option->getSelections() as $selection)
				{
					$productIds[] = $selection->getId();
				}
			}
			if(count($productIds) > 0)
			{
				$orderItems = implode(",", $product->getOrderItems());
				$productIds = implode(',', $productIds);
				//$eav = Mage::getResourceModel('eav/entity_attribute');
				$collection = Mage::getModel('sales/order_item')->getCollection();		
				$sql=$collection->getSelectCountSql();
				$sql
					->join(array('order'=>$collection->getTable('sales/order')), "order.entity_id= main_table.order_id AND customer_id = " . $this->getCustomer()->getId(),array())
					//->join(array('product_status'=>Mage::getConfig()->getTablePrefix().'catalog_product_entity_int'),'product_status.entity_id=main_table.product_id AND value=1 AND product_status.attribute_id='.$eav->getIdByCode('catalog_product', 'status'),array())
					->where("product_id IN (". $productIds .")")
					->where("parent_item_id IS NULL OR parent_item_id NOT IN (" .$orderItems . ")" );
				
				//die($collection->getSelect()->__toString());
				$s = $sql->__toString();
				$size = $this->getSize($sql, $collection->getConnection());
				if((int)$size > 0)
				{
					$id = $option->getOptionId();
					if(isset($options[$id]))
					{
						unset($options[$id]);
					}
				}
			}
			
		}
		
		$product->setProductOptions($options);
	}
	
	
	/**
	 *
	 * entfernen der bereits gekauften Multiselect Produkte
	 * @param Mage_Bundle_Model_Resource_Bundle $product
	 */
	protected function removeSoldSelections($product)
	{
		$options = $product->getProductOptions();
		$count = $product->getSoldProductCount();
		$productIds = array();
		//erstmal die Multiselect Produkte finden welche möglich sind
		foreach($options as $option)
		{
			if(($option->getType() == 'radio') || ($option->getType() == 'select')){
				continue;
			}
			if($option->getSelections())
			{
				foreach($option->getSelections() as $selection){
					$selection->setQty($selection->getSelectionQty() * $count);
					$productIds[] = $selection->getId();
				}
			}
		}
		
		
		if(count($productIds) == 0) return;
		
		$productIds = implode(',', $productIds);
		$collection = Mage::getModel('sales/order_item')->getCollection();
		$collection->getSelect()
			->join(array('order'=>$collection->getTable('sales/order')), "order.entity_id= main_table.order_id AND customer_id = " . $this->getCustomer()->getId(),array())
			->where("product_id IN (". $productIds .")");
		
		/* @var $orderitem Mage_Sales_Model_Order_Item */
		foreach($collection->getItems() as $orderitem)
		{
			foreach($options as $key =>$option)
			{
				if(($option->getType() == 'radio') || ($option->getType() == 'select')){
					continue;
				}
					
				$selections = $option->getSelections();
				foreach($selections as $k => $selection)
				{
					if($selection->getId() == $orderitem->getProductId())
					{
						$selection->setQty($selection->getQty() - $orderitem->getQtyToShip());
						if($selection->getQty() < 1){
							unset($selections[$k]);
						}
					}
				}
				$option->setSelections($selections);
				if(count($selections) == 0)
				{
					unset($options[$key]);
				}
			}
		}
		
		
	
		$product->setProductOptions($options);
	}
	
	
	protected function removeCardOptions($product)
	{
		$options = $product->getProductOptions();
	
		//erstmal die Optionen entfernen die gleichzeitig gekauft wurden

	
		//alle Produkte die im Warenkorb sind entfernen
		foreach($options as $option)
		{
			if(($option->getType() == 'checkbox') || ($option->getType() == 'multiselect')){
				continue;
			}
				
			$productIds = array();
	
			if($option->getSelections())
			{
				foreach($option->getSelections() as $selection)
				{
					$productIds[] = $selection->getId();
				}
			}
						
			if(count($productIds) > 0)
			{
				$productIds = implode(',', $productIds);
				$eav = Mage::getResourceModel('eav/entity_attribute');
				$collection = Mage::getModel('sales/quote_item')->getCollection();
				$sql = $collection->getSelectCountSql();
				
				$sql
				->join(array('order'=>$collection->getTable('sales/quote')), "order.entity_id= main_table.quote_id AND customer_id = " . $this->getCustomer()->getId(),array())
				->join(array('product_status'=>Mage::getConfig()->getTablePrefix().'catalog_product_entity_int'),'product_status.entity_id=main_table.product_id AND value=1 AND product_status.attribute_id='.$eav->getIdByCode('catalog_product', 'status'),array())
				->where("product_id IN (". $productIds .")")
				->where("is_active=1")
				->where("parent_item_id is NULL")
				//->where("parent_item_id NOT IN (" .$orderItems . ")" )
				;
	
				//die($collection->getSelect()->__toString());
	
				$size = $this->getSize($sql, $collection->getConnection());
				if((int)$size > 0)
				{
					$id = $option->getOptionId();
					if(isset($options[$id]))
					{
						unset($options[$id]);
					}
				}
			}
				
		}
	
		$product->setProductOptions($options);
	}
	
	
	protected function removeCardSelections($product)
	{
		$options = $product->getProductOptions();
		//erstmal die Multiselect Produkte finden welche möglich sind
		foreach($options as $option)
		{
			if(($option->getType() == 'radio') || ($option->getType() == 'select')){
				continue;
			}
		}
	
	
		$quote = $this->getQuote();
		if($quote == null) return;
		
	
		/* @var $orderitem Mage_Sales_Model_Quote_Item */
		foreach($quote->getAllItems() as $orderitem)
		{
			foreach($options as $key =>$option)
			{
				if(($option->getType() == 'radio') || ($option->getType() == 'select')){
					continue;
				}
					
				$selections = $option->getSelections();
				if($selections)
				{
					foreach($selections as $k => $selection)
					{
						if($selection->getId() == $orderitem->getProductId())
						{
							$selection->setQty($selection->getQty() - $orderitem->getQty());
							if($selection->getQty() < 1){
								unset($selections[$k]);
							}
						}
					}
					$option->setSelections($selections);
				}
				if(($selections==null) || (count($selections) == 0))
				{
					unset($options[$key]);
				}
			}
		}
	
	
	
		$product->setProductOptions($options);
	}
	
	
	/**
	 * entfernen der Optionen die nicht verfügbar sind
	 * @param Mage_Bundle_Model_Resource_Bundle $product
	 */
	protected function removeNotAvailable($product)
	{
		$options = $product->getProductOptions();
		foreach($options as $opt_id =>$option)
		{
			$selections = $option->getSelections();
			foreach( $selections as $key => $selection)
			{
				if($selection->getStatus() != Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
				{
					unset($selections[$key]);
				}else{
					$stockItem = $selection->getStockItem();
					//hat das Produkt eine Lagerverwaltung
					if($stockItem->getManageStock()){
						if($stockItem->getIsInStock() == 0){
							unset($selections[$key]);
						}
					}
				}
				
			}
			$option->setSelections($selections);
			if (!$selections || ((is_array($selections) || $selections instanceof Countable) && count($selections) < 1)) {
				unset($options[$opt_id]);
			}
		}
		$product->setProductOptions($options);
	}
	
 	public function getSize($sql, $connection)
    {
        $size = $connection->fetchOne($sql);
        return (int)$size;
    }
	
	/**
	 * die Optionen des Produktes ermitteln
	 */
	private function getProductOptions($product)
	{            
            $typeInstance = $product->getTypeInstance(true);
            $typeInstance->setStoreFilter($product->getStoreId(), $product);
            
            $optionCollection = $typeInstance->getOptionsCollection($product);

            $selectionCollection = $typeInstance->getSelectionsCollection(
                $typeInstance->getOptionsIds($product),
                $product
            );

            return $optionCollection->appendSelections($selectionCollection, false, false);   
	}
	
	
	/**
	 * Preis formatieren
	 * @param Mage_Bundle_Model_Resource_Bundle $product
	 */
	public function getFormatedPrice($product)
	{
		return Mage::helper('core')->currency($product->getPrice());
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Mage_Checkout_Model_Session
	 */
	private function getCheckout()
	{
		return Mage::getSingleton('checkout/session');
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Mage_Sales_Model_Quote
	 */
	private function getQuote()
	{
		return $this->getCheckout()->getQuote();
	}
	
	
	
	
}
