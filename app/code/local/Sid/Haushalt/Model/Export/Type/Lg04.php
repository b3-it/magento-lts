<?php
/**
 *  Exportklasse für Haushalt
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Model_Export_Type_Lg04 extends Sid_Haushalt_Model_Export_Abstract
{
	private $_lg04 = null;
	
	public function getExportData()
	{
		$orders = Mage::getModel('sales/order')->getCollection();
		$orders->getSelect()->where('entity_id IN (?)',implode(',',$this->_orderIds));
		$res = array();
		foreach($orders as $order)
		{
			$this->_storeId = $order->getStoreId();
			$line = array();
			$line[] = $order->getIncrementId();
			$line[] = $order->getCreatedAt();
			$line[] = $order->getBaseGandTotal();
			
			$res[] = implode("\t",$line);
		}
		
		$this->setExportStatus($this->_orderIds);
		
		return implode("\n", $res);
		
	}


// 	public function getExportData()
// 	{
// 		$this->_lg04 = new Sid_Haushalt_Model_Export_Type_Lg04_Format();
// 		$orders = Mage::getModel('sales/order')->getCollection();
// 		$orders->getSelect()->where('entity_id IN (?)',implode(',',$this->_orderIds));
// 		$res = array();
// 		foreach($orders as $order)
// 			{
// 				$this->_storeId = $order->getStoreId();
// 				$line = array();
// 				$line[] = $order->getIncrementId();
// 				$line[] = $order->getCreatedAt();
// 				$line[] = $order->getBaseGandTotal();
	
// 				$res[] = implode("\t",$line);
// 			}

// 		$this->setExportStatus($this->_orderIds);

// 		return implode("\n", $res);

// 	}

	private function getOrderData($order)
	{
		$content = array();
		$data = array();
		
		
		//kopfsatz
		$result = array();
		foreach($this->_lg04->getFields() as $idx => $field)
		{
			//var_dump($lg04->getFields()); die();
			if($field['name'] == 'line_no')
			{
				$result[] = $this->_lg04->getFormatedValue($idx,'0');
			}
			else
			{
				if(isset($data[$idx]))
				{
					$result[] = $this->_lg04->getFormatedValue($idx,$data[$idx],'headline');
				}else{
					$result[] = $this->_lg04->getFormatedValue($idx,"");
				}
			}
		}
		$content[] = implode('',$result);
		
		//positionssatz
		$result = array();
		foreach($this->_lg04->getFields() as $idx => $field)
		{
			//var_dump($lg04->getFields()); die();
			if($field['name'] == 'line_no')
			{
				$result[] = $this->_lg04->getFormatedValue($idx,'1');
			}
			else
			{
				if(isset($data[$idx]))
				{
					$result[] = $this->_lg04->getFormatedValue($idx,$data[$idx],'posline');
				}else{
					$result[] = $this->_lg04->getFormatedValue($idx,"");
				}
			}
		}
		$content[] = implode('',$result);
		
		return $content;
	}

}