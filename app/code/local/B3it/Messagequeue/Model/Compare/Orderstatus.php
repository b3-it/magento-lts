<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Messagequeue
 * @name       	B3it_Messagequeue_Model_Compare_Customergroup
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Compare_Orderstatus extends Mage_Core_Model_Abstract 
implements B3it_Messagequeue_Model_Compare_Interface
{
 	protected $_options = null;
 	
	public function getOptionArray(){
		if($this->_options == null)
		{
			$collection= Mage::getSingleton('sales/order_config')->getStatuses();
			$this->_options = array();
			foreach($collection as $key =>$item){
				$this->_options[$key] = $item;
			}
		}

		return $this->_options;
	}
	
	
public function getFormInputHtml()
	{
		$res = array();
		$res[] = "<select id=\"compare-value-orderstatus\" name=\"compare-value-orderstatus\" size=\"5\">";
		foreach($this->getOptionArray() as $k=>$v){
			$res[] = "<option value=\"{$k}\">{$v}</option>";
		}
		$res[] = "</select>";
		
		return implode(" ",$res);
	}
	
	public function getLabel4Value($value)
	{
		$res = array();
		$value = explode(',', $value);
		foreach($this->getOptionArray() as $k=>$v){
			if(in_array($k, $value)){
				$res[] = $v;
			}
		}
	
		return implode(',',$res);
	
	}
	
}
