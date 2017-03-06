<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 


class B3it_ConfigCompare_Model_PdfSections extends B3it_ConfigCompare_Model_Compare
{    
	protected $_attributesExcludeExport  = array('pdftemplate_section_id', 'pdftemplate_template_id', 'created_at' , 'updated_at');
	protected $_attributesExcludeCompare  = array('pdftemplate_section_id', 'pdftemplate_template_id','created_at' , 'updated_at', 'content', 'title');
	
	
	public function getCollection()
	{
		$collection = Mage::getModel('pdftemplate/section')->getCollection();
		$collection->getSelect()
			->join(array('section'=>$collection->getTable('pdftemplate/template')),'main_table.pdftemplate_template_id = section.pdftemplate_template_id');
		
	//die($collection->getSelect()->__toString());	
		return $collection;
	}
    
    public function getCollectionDiff($importXML)
    {
    	$this->_collection  = $this->getCollection();
    	if($importXML)
    	{
    		$notFound = array();
    		$this->_collectionArray = $this->_collection->toArray();
    		foreach($importXML as $xmlItem){
    			$item = simplexml_load_string($xmlItem->getValue());
    			$key = $this->__findInCollection((string)$item->title,(string)$item->type, (string) $item->sectiontype);
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
	    		$this->_collection->add((array)$item);
	    	}
	    	$this->_collection->setIsLoaded();
    	}
    	return $this->_collection;
    	
    }

    private function __findInCollection($path ,$type, $sectiontype){
    	foreach($this->_collectionArray['items'] as $key => $item){
    		if($item['title'] == $path){
    			if($item['sectiontype'] == $sectiontype){
	    			if($item['type'] == $type){
	    				return $key;
	    			}
    			}
    		}
    	}
    	return null;
    }
    
   
}