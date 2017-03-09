<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 


class B3it_ConfigCompare_Model_Emailtemplates extends B3it_ConfigCompare_Model_Compare
{
	
	protected $_attributesExcludeExport  = array('template_id', 'modified_at' );
	protected $_attributesExcludeCompare  = array('template_id', 'modified_at' , 'template_subject', 'template_text');
    
	public function getCollection()
	{
		$collection = Mage::getModel('core/email_template')->getCollection();
		
		
		return $collection;
	}
    
    public function getCollectionDiff($importXML)
    {
    	$this->_collection  =  $this->getCollection();
    	if($importXML)
    	{
    		$notFound = array();
    		$this->_collectionArray = $this->_collection->toArray();
    		foreach($importXML as $xmlItem){
    			$item = simplexml_load_string($xmlItem->getValue());
    			$key = $this->__findInCollection((string)$item->template_code);
    			if($key !== null){
    				$diff2 = $this->_compareDiff($this->_collectionArray['items'][$key]['template_subject'], (string)$item->template_subject);
    				$diff = $this->_compareDiff($this->_collectionArray['items'][$key]['template_text'], (string)$item->template_text);
    				$diff3 = $this->_getAttributeDiff($this->_collectionArray['items'][$key], (array)$item);
    				if(($diff === true) && ($diff2 === true) && ($diff3 === true)) {
    					unset($this->_collectionArray['items'][$key]);
    				}else{
    					if($diff !== true){
    						$this->_collectionArray['items'][$key]['diff'] = $diff;
    					}
    					if($diff2 !== true){
    						$this->_collectionArray['items'][$key]['title'] = $diff2;
    					}
    					if($diff3 !== true){
    						$this->_collectionArray['items'][$key]['attribute'] = $diff3;
    					}
    				}
    			} else {
	    			$notFound[] = $item;
	    		}
    		}
    	
	    	
	    	$this->_collection = Mage::getModel('configcompare/coreConfigData')->getCollection();
	    	foreach($this->_collectionArray['items'] as $item){
	    		$this->_collection->add($item);
	    	}
	    	foreach($notFound as $item){
	    		$item = (array)$item;
	    		$item['attribute'] =  $this->_getAttributeDiff(array(), $item);
	    		$this->_collection->add($item);
	    	}
	    	$this->_collection->setIsLoaded();
    	}
    	return $this->_collection;
    	
    }

    

    
    private function __findInCollection($path){
    	foreach($this->_collectionArray['items'] as $key => $item){
    		if($item['template_code'] == $path){
    				return $key;
    		}
    	}
    	return null;
    }
}