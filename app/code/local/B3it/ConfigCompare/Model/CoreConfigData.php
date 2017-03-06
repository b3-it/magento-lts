<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Model_CoreConfigData extends B3it_ConfigCompare_Model_Compare
{
	private $collection = null;
	private $collectionArray = null;
	
	protected $_attributesExcludeExport  = array('config_id');
	protected $_attributesExcludeCompare  = array('config_id');
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('configcompare/coreConfigData');
    }
    
    public function getExportCollection()
    {
    	 return Mage::getModel('core/config_data')->getCollection();
    }
    
    public function getCollectionDiff($importXML)
    {
    	$this->collection = Mage::getModel('core/config_data')->getCollection();
    	if($importXML)
    	{
    		$notFound = array();
    		$this->collectionArray = $this->collection->toArray();
    		foreach($importXML as $xmlItem){
    			$item = simplexml_load_string($xmlItem->getValue());
    			$key = $this->findInCollection((string)$item->path,(string)$item->scope_id,(string)$item->scope);
    			if($key !== null){
    				$myValue = str_replace(array("\r\n", "\r"),"\n", $this->collectionArray['items'][$key]['value']);
    				$compare = str_replace(array("\r\n", "\r"),"\n", (string)$item->value);
	    			if($myValue == $compare){
	    				unset($this->collectionArray['items'][$key]);
	    			}else{
	    				$this->collectionArray['items'][$key]['other_value'] = (string)$item->value;
	    			}
    			} else {
	    			$notFound[] = $item;
	    		}
    		}
    	
	    	
	    	$this->collection = Mage::getModel('configcompare/coreConfigData')->getCollection();
	    	foreach($this->collectionArray['items'] as $item){
	    		$this->collection->add($item);
	    	}
	    	foreach($notFound as $item){
	    		$this->collection->addOther((array)$item);
	    	}
	    	$this->collection->setIsLoaded();
    	}
    	return $this->collection;
    	
    }
    
    private function findInCollection($path ,$scope_id=0, $scope = 'default'){
    	foreach($this->collectionArray['items'] as $key => $item){
    		if($item['scope'] == $scope){
    			if($item['scope_id'] == $scope_id){
		    		if( $item['path'] == $path){
		    			return $key;
		    		}
    			}
    		}
    	}
    	return null;
    }
    

}