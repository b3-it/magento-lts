<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 


class B3it_ConfigCompare_Model_PdfBlocks extends B3it_ConfigCompare_Model_Compare
{
	
	protected $_attributesCompare  = array('payment','customer_group','shipping','store_id','prio','pos','status','tax_rule');
	protected $_attributesExport  = array('ident','payment','customer_group','shipping','store_id','prio','pos',' tatus','tax_rule');
    
	public function getCollection()
	{
		$collection = Mage::getModel('pdftemplate/blocks')->getCollection();
		return $collection;
	}
    
    public function getCollectionDiff($importXML)
    {
    	$this->_collection  = $this->getCollection();
    	//if($importXML)
    	{
    		$notFound = array();
    		$this->_collectionArray = $this->_collection->toArray();
    		foreach($importXML as $xmlItem){
    			$item = simplexml_load_string($xmlItem->getValue());
    			$key = $this->__findInCollection((string)$item->ident,(string)$item->store_id, (string)$item->customer_group, (string)$item->shipping, (string)$item->payment,(string)$item->tax_rule );
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

    
    public function export($xml, $xml_node)
    {
    	$collection =  $this->getCollection();
    	foreach($collection->getItems() as $item){
    		$xml_item = $xml->createElement( "cms_block");
    		$xml_node->appendChild($xml_item);
    
    		
    			
    		foreach($this->_attributesExport as $field)
    		{
    			$this->_addElement($xml, $xml_item, $item, $field);
    		}
    
    		$data = $xml->createCDATASection($item->getTitle());
    		$node = $xml->createElement("title");
    		$node->appendChild($data);
    		$xml_item->appendChild($node);
    
    		$data = $xml->createCDATASection($item->getContent());
    		$node = $xml->createElement("content");
    		$node->appendChild($data);
    		$xml_item->appendChild($node);
    	}
    }
    
    
    
    private function __findInCollection($ident, $store_id, $customer_group, $shipping, $payment, $tax_rule){
    	foreach($this->_collectionArray['items'] as $key => $item){
    		if($item['ident'] == $ident){
    			if($item['store_id'] == $store_id){
	    			if($item['customer_group'] == $customer_group){
	    				if($item['shipping'] == $shipping){
	    					if($item['payment'] == $payment){
	    						if($item['tax_rule'] == $tax_rule){
	    							return $key;
	    						}
	    					}
	    				}
	    			}
    			}
    		}
    	}
    	return null;
    }
    
}