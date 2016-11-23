<?php

class Sid_Framecontract_Model_Stockstatus extends Varien_Object
{
  
	/**
	 * Warnung versenden falls ein Schwellwert erreicht ist
	 * @return Sid_Framecontract_Model_Stockstatus
	 */
	public function sendStockStatusEmail()
	{
		$collection = Mage::helper('framecontract')->getStockStatusCollection();
		
		
		
		$qty = intval(Mage::getStoreConfig("framecontract/contract_qty/qty"));
		$expr = new Zend_Db_Expr('IF(qty.value <> 0, ((qty.value - stock.qty) / qty.value * 100), 0) >= ' . $qty);
		$expr2 = new Zend_Db_Expr('losdetail.stock_status_send = 0');
		
		$collection->getSelect()
			->join(array('losdetail' => $collection->getTable('framecontract_los')),'losdetail.los_id = los.value')
			->where($expr)
			->where($expr2)
			->order('store_group');
		
		
		$template = "framecontract/contract_qty/email_template";
		$lastStore = null;
		$lastItem = null;
		$data = array();
		$data['items'] = array();
		$this->setLog('Found '.count($collection->getItems()).' low Stock Items (less than '.$qty.'%) in DB');
		$this->setLog($collection->getSelect()->__toString());
		die();
		foreach($collection->getItems() as $item)
		{
			if($lastStore && $lastStore != $item->getStoreGroup())
			{
				$data['formated_items'] = $this->_formatItemsHTML($data['items']);
				$recipients = array();
				$recipients[] = array('name'=>Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore), 'email' => Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore));
				
				//mail senden
				Mage::helper('framecontract')->sendEmail($template, $recipients, $data, $lastStore);
				//status am los speichern
				Mage::getModel('framecontract/los')->load($lastItem->getLosId())->setStockStatusSend(1)->save();
				//neu initialisieren
				$data = array();
				$data['items'] = array();
				
			}
			
			$lastStore = $item->getStoreGroup();
			$data['items'][] = $item;
			$lastItem = $item;
			
		}
		
		if(count($data['items']) > 0)
		{
			$data['formated_items'] = $this->_formatItemsHTML($data['items']);
			$recipients = array();
			$recipients[] = array('name'=>Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore), 'email' => Mage::getStoreConfig("framecontract/contract_qty/recipient", $lastStore));
					
			//mail senden
			Mage::helper('framecontract')->sendEmail($template, $recipients, $data, $lastStore);
			//status am los speichern
			Mage::getModel('framecontract/los')->load($lastItem->getLosId())->setStockStatusSend(1)->save();
		}
		
		//die($collection->getSelect()->__toString());
		return $this;
	}
	
	//die Items so formatieren, dass eine Tabelle entsteht
	private function _formatItemsHTML($items)
	{
		$res = array();
		$res[] = "<table><tr><td> Product </td><td> Artikelnummer </td><td> Bestellt </td><td> Bestellt [%]</td><tr>";
		
		foreach ($items as $item)
		{
			$res[] = sprintf("<tr><td>%s</td><td>%s</td><td>%d</td><td>%d</td></tr>",$item->getName(),$item->getSku(), $item->getSold(), $item->getSoldP());
			
		}
		
		$res[] = "</table>";
		
		return implode(' ', $res);
	}
	
}