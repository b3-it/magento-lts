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
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('configcompare/coreConfigData');
    }
    
    
    
    public abstract function getCollectionDiff($importXML);
    
    protected function _compareDiff($from, $to)
    {
    	$myValue = str_replace(array("\r\n", "\r"),"\n", $from);
    	$compare = str_replace(array("\r\n", "\r"),"\n", $to);
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
    	foreach($this->_attributesCompare as $field)
    	{
    		if((string)$from[$field] != (string)$to[$field]){
    			$res[] = $field. ': ' . $this->_compareDiff($from[$field], $to[$field]); 
    		}
    	}
    	
    	if(count($res) == 0 ) return true;    
    	return implode('<br>', $res);
    }
    
    
    protected function _findInCollection($path ,$stores){
    	foreach($this->_collectionArray['items'] as $key => $item){
    		if($item['identifier'] == $path){
    			if($item['stores'] == $stores){
		    			return $key;
    			}
    		}
    	}
    	return null;
    }
    
    /**
     * Helper für den xml Export
     * @param unknown $xml
     * @param unknown $xml_node
     * @param unknown $item
     * @param unknown $field
     */
    protected function _addElement($xml, $xml_node ,$item, $field)
    {
    	//$func = 'get'
    	$node = $xml->createElement($field,$item->getData($field));
    	$xml_node->appendChild($node);
    }
    
}