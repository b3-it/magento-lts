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
		$ids = implode(',',$this->_orderIds);
		$orders->getSelect()->where('entity_id IN ('.$ids.')');
		//$sql = $orders->getSelect()->__toString();
		$res = [[]];
		/* @var $order Mage_Sales_Model_Order */ 
		$orders = $orders->getItems();
		foreach($orders as $order)
		{
			$format = $this->getOrderData($order);
			$res[] = $format;
		}
        if (version_compare(PHP_VERSION, '5.6', '>=')) {
            $res = array_merge(...$res);
        } else {
            /* PHP below 5.6 */
            $res = call_user_func_array('array_merge', $$res);
        }
		//den ExportStatus der Bestellung ändern 
		$this->setExportStatus($this->_orderIds);
		return implode("\n", $res);
		
	}

	/**
	 * Parameter aus config.xml  lesen
	 * mögliche Werte:
	 * att_1_id, att_2_id, att_3_id, att_6, att_7_i, client, dim_6, increment_pool/min, increment_pool/max, budget_prefix, accountable
	 * @param String $key
	 * @return Mage_Core_Model_Config_Element
	 */
	private function getConfigData($key)
	{
		$val = Mage::getConfig()->getNode('sid_haushaltsysteme/lg04/params/'.$key)->__toString();
		return $val;
	}
	
	/***
	 * 
	 * @param Mage_Sales_Model_Order       $order
	 * @param Mage_Sales_Model_Order_Item  $orderItem
	 * @return string
	 */
	private function getBudgedNumber($order, $orderItem)
	{
		
		$res = $this->getConfigData('dim_2');
		return $res;//.$order->getOrderData($this->getFormatedOrderDate($order,'Y'));
	}
	
	
	
	
	private function getOrderData($order)
	{
		$content = array();
		$batchId = $order->getId().'_'.time();
		$lineNr = 0;
		
		$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
		$vendor = $contract->getVendor();
		
		/* @var $head Sid_Haushalt_Model_Export_Type_Lg04_Head */
		$head = Mage::getModel('sidhaushalt/export_type_lg04_head');
		$head->setAccountable($this->getConfigData('accountable')); //konstante
		$head->setAparId($vendor->getU4MainAparId());
		$head->setAtt1Id($this->getConfigData('att_1_id'));
		$head->setAtt2Id($this->getConfigData('att_2_id'));
		$head->setAtt3Id($this->getConfigData('att_3_id'));
		$head->setAtt6Id($this->getConfigData('att_6_id'));
		$head->setAtt7Id($this->getConfigData('att_7_id'));
		$head->setResponsible($contract->getU4Responsible());
		$head->setBatchId($batchId);
		$head->setClient($this->getConfigData('client'));
		$head->setLineNo($lineNr);
		$head->setExtOrdRef($order->getIncrementId());
		
		$head->setMainAparId($vendor->getU4MainAparId());
		
		$head->setOrderDate($this->getFormatedOrderDate($order));
		$head->setOrderId($order->getU4IncrementId());
		$head->setPeriod($this->getFormatedOrderDate($order,'Ym'));
		$head->setTransType('41');

		$format = $head->getFormatedData();
		$content[] = implode('',$format);
		
		/* @var $item Mage_Sales_Model_Order_Item */
		foreach($order->getAllItems() as $item)
		{
			$lineNr++;
			/* @var $pos Sid_Haushalt_Model_Export_Type_Lg04_Pos */
			$pos = Mage::getModel('sidhaushalt/export_type_lg04_pos');
			$pos->setAccount($item->getProduct()->getU4Account());
			$pos->setAmount($item->getBaseRowTotal());
			$pos->setAmountSet('1');
			$pos->setArtDescr($item->getName());
			$pos->setArticle($item->getProduct()->getU4Article());
			$pos->setBatchId($batchId);
			$pos->setClient($this->getConfigData('client'));
			$pos->setCurrency($order->getBaseCurrencyCode());
			$pos->setDim1($item->getProduct()->getU4Dim1());
			$pos->setDim2($this->getBudgedNumber($order, $item)); 
			$pos->setDim3($item->getProduct()->getU4Dim3());
			$pos->setDim6($this->getConfigData('dim_6'));
			$pos->setDim7($item->getProduct()->getU4Account());
			$pos->setLineNo($lineNr);
			$pos->setOrderId($order->getU4IncrementId());
			$pos->setPeriod($this->getFormatedOrderDate($order,'Ym'));
			$pos->setTransType('41');
			$pos->setUnitCode('STK');
			$pos->setUnitPrice($item->getBasePrice());
			$pos->setValue1($item->getQtyOrdered());
			
			$format = $pos->getFormatedData();
			$content[] = implode('',$format);
		}
		
		
		return $content;
	}
	
	private function getFormatedOrderDate($order,$format = 'Ymd')
	{
		$date = $order->getCreatedAtDate()->getTimestamp();
		return date($format,$date);
	}
	

}