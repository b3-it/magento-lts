<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Messagequeue
 * @name       	B3it_Messagequeue_Model_Queue_Processing_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Processing_Invoicepay extends B3it_Messagequeue_Model_Queue_Processing_Abstract
implements B3it_Messagequeue_Model_Queue_Processing_Interface
{
    public function preProcessing($ruleset,$message,$data)
    {
    	parent::_preProcessing($ruleset, $message, $data);
    	$message->setStoreId($data->getStoreId());
    	return $this;
    }

    
 
    
    protected function _getValue($field,$data)
    {
    	$keys = explode('.', $field);
    	
    	if($data->getOrder() == null){
    		$data->setOrder(Mage::getModel('sales/order')->load($data->getOrderId()));
    	}
    	
    	$res = null;
    	if(reset($keys) == 'orderitem'){
    		$res = array();
    		array_shift($keys);
    		foreach($data->getOrder()->getAllItems() as $item)
    		{
    			$res[] = $this->_extractData($item, $keys);
    		}
    	}else{
    		$res = $this->_extractData($data, $keys);
    	}
    	
    	return $res;
    }
    	
    public function processText($ruleset,  $message, $data = null)
    {
    	return parent::_processText($ruleset, $message, $data);
    }
   
}
