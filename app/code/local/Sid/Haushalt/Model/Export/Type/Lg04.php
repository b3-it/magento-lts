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
	
		//mapping order -> lg04
		$data = array();
		
		
		$data['accountable'] = '';
		$data['apar_id'] = '';
		$data['att_1_id'] = '';
		$data['att_2_id'] = '';
		$data['att_3_id'] = '';
		$data['att_6_id'] = '';
		$data['att_7_id'] = '';
		$data['batch_id'] = '';
		$data['client'] = '';
		$data['currency'] = '';
		$data['line_no'] = '';
		$data['main_apar_id'] = '';
		$data['order_date'] = '';
		$data['order_id'] = '';
		$data['period'] = '';
		$data['trans_type'] = '';
		
		
		
		
		$format = $this->getHeadData($data);
		$content = array_merge($content, $format);
		
		foreach($order->getAllItems() as $item)
		{
			$data = array();
			//mapping order -> lg04
			$data['account'] = '';
			$data['amount'] = '';
			$data['amount_set'] = '';
			$data['art_descr'] = '';
			$data['article'] = '';
			$data['batch_id'] = '';
			$data['client'] = '';
			$data['currency'] = '';
			$data['dim_1'] = '';
			$data['dim_2'] = '';
			$data['dim_3'] = '';
			$data['dim_6'] = '';
			$data['dim_7'] = '';
			$data['line_no'] = '';
			$data['order_id'] = '';
			$data['period'] = '';
			$data['trans_type'] = '';
			$data['unit_code'] = '';
			$data['unit_price'] = '';
			$data['value_1'] = '';
			
			$format = $this->getPosData($data);
			$content = array_merge($content, $format);
		}
		
		$content[] = implode('',$result);
		return $content;
	}
	
	private function getHeadData($data = array())
	{
		$content = array();
	
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
	
		return $content;
	}
	
	private function getPosData($data = array())
	{
		$content = array();
	
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