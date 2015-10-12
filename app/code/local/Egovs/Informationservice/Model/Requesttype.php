<?php

class Egovs_Informationservice_Model_Requesttype extends Mage_Core_Model_Abstract
{
	const OUTGOING_REQEST = 0;
	const INCOMMING_REQEST = 1;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('informationservice/requesttype');
    }
    
    
    public function directionToOptionArray()
    {
    	$res = array();
    	$res[] = array('value'=>Egovs_Informationservice_Model_Requesttype::INCOMMING_REQEST, 'label'=>Mage::helper('informationservice')->__('Question'));
    	$res[] = array('value'=>Egovs_Informationservice_Model_Requesttype::OUTGOING_REQEST, 'label'=>Mage::helper('informationservice')->__('Answer'));
    	
    	return  $res;
    }
    
    public function directionToOptionValueArray()
    {
    	$res = array();
    	$res[Egovs_Informationservice_Model_Requesttype::INCOMMING_REQEST] = Mage::helper('informationservice')->__('Question');
    	$res[Egovs_Informationservice_Model_Requesttype::OUTGOING_REQEST] = Mage::helper('informationservice')->__('Answer');
    	
    	return  $res;
    }
    
    
 	public function getInputTypesAsOptionArray()
 	{
    	$res = array();
    	foreach ($this->getCollection()->getItems() as $item)
    	{
    		if($item->getDirection() == Egovs_Informationservice_Model_Requesttype::INCOMMING_REQEST )
    		{
    			$res[] = array('label'=>$item->getTitle(), 'value'=>$item->getId());
    		}
    	}
    	
    	return $res;
    }
    
 	public function getOutputTypesAsOptionArray()
 	{
    	$res = array();
    	foreach ($this->getCollection()->getItems() as $item)
    	{
    		if($item->getDirection() == Egovs_Informationservice_Model_Requesttype::OUTGOING_REQEST )
    		{
    			$res[] = array('label'=>$item->getTitle(), 'value'=>$item->getId());
    		}
    	}
    	
    	return $res;
    }
    
 	public function getOutputTypesAsOptionValueArray()
 	{
    	$res = array();
    	foreach ($this->getCollection()->getItems() as $item)
    	{
    		if($item->getDirection() == Egovs_Informationservice_Model_Requesttype::OUTGOING_REQEST )
    		{
    			$res[$item->getId()] = $item->getTitle();
    		}
    	}
    	
    	return $res;
    }
    
    
}