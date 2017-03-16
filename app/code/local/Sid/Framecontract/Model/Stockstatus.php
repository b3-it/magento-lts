<?php

class Sid_Framecontract_Model_Stockstatus extends Varien_Object
{
  
	/**
	 * Warnung versenden falls ein Schwellwert erreicht ist
	 * @return Sid_Framecontract_Model_Stockstatus
	 */
	public function sendStockStatusEmail()
	{
		
		$websites = Mage::app()->getWebsites();
		
		
		foreach($websites as $website)
		{ 
			$collection = Mage::helper('framecontract')->getStockStatusCollection();
			
			
			$qty = intval(Mage::app()->getWebsite($website->getId())->getConfig('framecontract/contract_qty/qty')); // Mage::getStoreConfig("framecontract/contract_qty/qty"));
			$expr = new Zend_Db_Expr('IF(qty.value <> 0, ((qty.value - stock.qty) / qty.value * 100), 0) >= ' . $qty);
			$expr2 = new Zend_Db_Expr('e.stock_status_send = 0');
			
			$collection->getSelect()
				->join(array('losdetail' => $collection->getTable('framecontract_los')),'losdetail.los_id = los.value')
				->join(array('website'=>$collection->getTable('catalog/product_website')),'website.product_id = e.entity_id AND website.website_id = '. intval($website->getId()))
				->where($expr)
				->where($expr2)
				->order('store_group');
			
			$template =  Mage::app()->getWebsite($website->getId())->getConfig("framecontract/contract_qty/warning_email_template");
			$lastStore = null;
			$lastItem = null;
			$data = array();
			$data['items'] = array();
	//		$this->setLog('Found '.count($collection->getItems()).' low Stock Items (less than '.$qty.'%) in DB');
			$this->setLog($collection->getSelect()->__toString());
			
			$sendItems = array();
			foreach($collection->getItems() as $item)
			{
				if($lastStore && $lastStore != $item->getStoreGroup())
				{
					$data['formated_items'] = $this->_formatItemsHTML($data['items']);
					$recipients = array();
					$rec = Mage::app()->getWebsite($website->getId())->getConfig('framecontract/contract_qty/recipient');
					$recipients[] = array('name'=>Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore), 'email' => Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore));
					
					//mail senden
					Mage::helper('framecontract')->sendEmail($template, $recipients, $data, $lastStore);
					
					//neu initialisieren
					$data = array();
					$data['items'] = array();
					
				}
				
				$lastStore = $item->getStoreGroup();
				$data['items'][] = $item;
				$lastItem = $item;
				//status am los speichern
				$sendItems[] = $item->getId();
			}
			
			if(count($data['items']) > 0)
			{
				$data['formated_items'] = $this->_formatItemsHTML($data['items']);
				$recipients = array();
				$rec = Mage::app()->getWebsite($website->getId())->getConfig('framecontract/contract_qty/recipient');
				$recipients[] = array('name'=>Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore), 'email' => Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore));
						
				//mail senden
				Mage::helper('framecontract')->sendEmail($template, $recipients, $data, $lastStore);
				
			}
			
			$this->_saveItemsStockStatusSend($sendItems);
		}
		//die($collection->getSelect()->__toString());
		return $this;
	}
	
	//die Items so formatieren, dass eine Tabelle entsteht
	private function _formatItemsHTML($items)
	{
		$res = array();
		$res[] = "<table><tr><td> Produkt </td><td> Artikelnummer </td><td> Bestellt </td><td> Bestellt [%]</td><td>Rahemenvertrag</td><td>Los</td></tr>";
		
		foreach ($items as $item)
		{
			$contract = Mage::getModel('framecontract/contract')->load($item->getFramecontractContractId());
			$los = Mage::getModel('framecontract/los')->load($item->getLosId());
			$res[] = sprintf("<tr><td>%s</td><td>%s</td><td>%d</td><td>%d</td><td>%s</td><td>%s</td></tr>",$item->getName(),$item->getSku(), $item->getSold(), $item->getSoldP(),$contract->getTitle(),$los->getTitle());
			
		}
		
		$res[] = "</table>";
		
		return implode(' ', $res);
	}
	
	/**
	 * am Produkt speichern om eine Mail über den Lagerbestand gesendet wurde
	 * @param array $itemIds
	 */
	protected function _saveItemsStockStatusSend($itemIds){
		$model = Mage::getModel('framecontract/contract')->getResource();
		$model->saveItemsStockStatusSend($itemIds);
	}
}