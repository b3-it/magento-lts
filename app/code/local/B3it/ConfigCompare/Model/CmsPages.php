<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 


class B3it_ConfigCompare_Model_CmsPages extends B3it_ConfigCompare_Model_Compare
{	
	protected $_attributesExcludeExport  = array('page_id', 'creation_time' , 'update_time');
	protected $_attributesExcludeCompare  = array('page_id', 'creation_time' , 'update_time', 'content', 'title');
	
	public function getCollection()
	{
		$collection = Mage::getModel('cms/page')->getCollection();
		
		$stores = new Zend_Db_Expr('(SELECT page_id, group_concat(store_id) AS stores FROM '.$collection->getTable('cms/page_store'). ' WHERE store_id IN (0,'.$this->getStoreId().') GROUP BY page_id ORDER BY store_id)');
		$collection->getSelect()
		->joinleft(array('store'=>$stores),'store.page_id = main_table.page_id',array('stores'));

		//die($collection->getSelect()->__toString());		
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
    			$key = $this->_findInCollection((string)$item->identifier,(string)$item->stores);
    			if($key !== null){
    				$diff = $this->_compareDiff($this->_collectionArray['items'][$key]['content'], (string)$item->content);
    				$diff2 = $this->_compareDiff($this->_collectionArray['items'][$key]['title'], (string)$item->title);
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

    

    
}