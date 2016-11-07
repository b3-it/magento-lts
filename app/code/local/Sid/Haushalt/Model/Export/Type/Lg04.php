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
		$this->_lg04 = Mage::getModel('sidhaushalt/export_type_lg04_format');
		
		$orders = Mage::getModel('sales/order')->getCollection();
		$orders->getSelect()->where('entity_id IN (?)',implode(',',$this->_orderIds));
		$res = array();
		/* @var $order Mage_Sales_Model_Order */ 
		foreach($orders as $order)
		{
			$format = $this->getOrderData($order);
			$res = array_merge($res, $format);
		}
		//den ExportStatus der Bestellung ändern 
		$this->setExportStatus($this->_orderIds);
		return implode("\n", $res);
		
	}

	private function getOrderData($order)
	{
		$content = array();

		/* @var $head Sid_Haushalt_Model_Export_Type_Lg04_Head */
		$head = Mage::getModel('sidhaushalt/export_type_lg04_head');
		$head->setAccountable('');
		$head->setAparId('');
		$head->setAtt1Id('');
		$head->setAtt2Id('');
		$head->setAtt3Id('');
		$head->setAtt6Id('');
		$head->setAtt7Id('');
		$head->setBatchId('');
		$head->setClient('');
		$head->setCurrency('');
		$head->setExtOrdRef('');
		$head->setMainAparId('');
		$head->setOrderDate('');
		$head->setOrderId('');
		$head->setPeriod('');
		$head->setTransType('');

		$format = $head->getFormatedData();
		$content = array_merge($content, $format);
		
		foreach($order->getAllItems() as $item)
		{
			
			/* @var $pos Sid_Haushalt_Model_Export_Type_Lg04_Pos */
			$pos = Mage::getModel('sidhaushalt/export_type_lg04_pos');

			$pos->setAccount('');
			$pos->setAmount('');
			$pos->setAmountSet('');
			$pos->setArtDescr('');
			$pos->setArticle('');
			$pos->setBatchId('');
			$pos->setClient('');
			$pos->setCurrency('');
			$pos->setDim1('');
			$pos->setDim2('');
			$pos->setDim3('');
			$pos->setDim6('');
			$pos->setDim7('');
			$pos->setLineNo('');
			$pos->setOrderId('');
			$pos->setPeriod('');
			$pos->setTransType('');
			$pos->setUnitCode('');
			$pos->setUnitPrice('');
			$pos->setValue1('');
			
			
			
			
			
			$format = $pos->getFormatedData();
			$content = array_merge($content, $format);
		}
		
		$content[] = implode('',$result);
		return $content;
	}
	
	
	

}