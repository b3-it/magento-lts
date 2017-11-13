<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 


require_once(__DIR__.DS.'FineDiff'.DS.'finediff.php');


abstract class B3it_ConfigCompare_Model_Compare extends Mage_Core_Model_Abstract
{
	protected $_collection = null;
	protected $_collectionArray = null;
	
	protected $_attributesCompare  = array();
	protected $_attributesExcludeExport  = array('id');
	protected $_attributesExcludeCompare  = array('id');
	
	protected $_storeId = 0;
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('configcompare/coreConfigData');
    }
    
    
    public function setStoreId($storeId)
    {
    	$this->_storeId = intval($storeId);
    	return $this;
    }
    
    public function getStoreId()
    {
    	return $this->_storeId;
    }
    
    
    public abstract function getCollectionDiff($importXML);
    
    protected function _compareDiff($from, $to)
    {
    	$myValue = htmlentities(str_replace(array("\r\n", "\r"),"\n", $from));
    	$compare = htmlentities(str_replace(array("\r\n", "\r"),"\n", $to));
    	 
    	//$myValue = str_replace(array("\r\n", "\r"),"\n", $from);
    	//$compare = str_replace(array("\r\n", "\r"),"\n", $to);
    	if($myValue == $compare){
    		return true;
    	}else{
    		$from_text = mb_convert_encoding($compare, 'HTML-ENTITIES', 'UTF-8');
    		$to_text = mb_convert_encoding($myValue, 'HTML-ENTITIES', 'UTF-8');
    	
    		$diff_opcodes = FineDiff::getDiffOpcodes($from_text, $to_text, FineDiff::$characterGranularity);
    		$diff_opcodes_len = strlen($diff_opcodes);
    		$diff = FineDiff::renderDiffToHTMLFromOpcodes($from_text, $diff_opcodes);
    		return $diff;
    	}
    }
    
    
    protected function _getAttributeDiff($from, $to)
    {
    	$res = array();
    	$fields = array_keys(array_merge($from, $to));
    	foreach($fields as $field)
    	{
    		if(array_search($field, $this->_attributesExcludeCompare) === false){
    			$_from = isset($from[$field]) ? (string)$from[$field]: '';
    			$_to = isset($to[$field]) ? (string)$to[$field]: '';
    			
	    		if((string)$_from != (string)$_to){
	    			$diff = $this->_compareDiff($_from, $_to); 
	    			if($diff !== true){
	    				$res[] = $field. ': ' . $diff;
	    			}
	    		}
    		}
    	}
    	
    	if(count($res) == 0 ) return true;    
    	return implode('<br>', $res);
    }
    
    
    protected function _findInCollection($path ,$stores){
    	foreach($this->_collectionArray['items'] as $key => $item){
    		if($item['identifier'] == $path){
    			//if($item['stores'] == $stores)
    			{
		    			return $key;
    			}
    		}
    	}
    	return null;
    }
    
    /**
     * Helper für den xml Export
     * @param Varien_Simplexml_Element $xml
     * @param Varien_Simplexml_Element $xml_node
     * @param object $item
     * @param string $field
     */
    protected function _addElement($xml, $xml_node ,$item, $field)
    {
    	//$func = 'get'
    	//$node = $xml->createElement($field,$item->getData($field));
    	//$xml_node->appendChild($node);
    	
    	
    	$data = $xml->createCDATASection($item->getData($field));
    	$node = $xml->createElement($field);
    	$node->appendChild($data);
    	$xml_node->appendChild($node);
    	
    	
    }
    
    public function getExportCollection()
    {
    	return $this->getCollection();
    }
    
    
    public function export($xml, $xml_node, $label="not_defined")
    {
    	$collection =  $this->getExportCollection();
    	
    	if(is_array($collection)){
    		$items = $collection;
    	}else{
    		$items = $collection->getItems();
    	}
    	
    	foreach($items as $item){
    		$xml_item = $xml->createElement( $label);
    		$xml_node->appendChild($xml_item);
    
    		$data = $item->getData();
        	foreach($data as $field => $value)
    		{
    			if(array_search($field, $this->_attributesExcludeExport) === false){
    				$this->_addElement($xml, $xml_item, $item, $field);
    			}
    		}
    	}
    }
    
}