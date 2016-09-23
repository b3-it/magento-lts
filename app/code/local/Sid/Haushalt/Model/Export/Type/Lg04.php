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
}