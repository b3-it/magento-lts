<?php
/**
 * Sid ExportOrder_Format Transdoc
 *
 * Erzeugen eines XML Streams für transdoc2.1
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Transdoc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Parent = null;
	protected $_Tag = "UNDEFINED";
	
	/** var DOMElement */
	protected $_MyNode = null;
	
	/* var @$_xml  DOMDocument */
	protected $_xml = null;
	
    public function __construct($parent, $xml)
    {
      $this->_Parent = $parent;
      $this->_xml = $xml;
    }

    /**
     * helper: erzeugen und einfügen
     * @param string $name Knotenname
     * @param string $value Wert
     * @param DOMElement $parent Elternknoten
     * @return DOMElement
     */
    protected function _addElement($name, $value = null,  $parent = null)
    {
    	$node = $this->_xml->createElement($name, $value);
    	if($parent == null){
    		$parent = $this->_xml;
    	}
    	//var_dump($parent);
    	$parent->appendChild($node);
    	return $node;
    }
    
    public function getXmlNode()
    {
    	$this->_MyNode = $this->_addElement($this->_Tag, null, $this->_Parent);
    	return $this->_MyNode;
    }
    
    public function prepareXml($newNode)
    {
    	return $this;
    }

    public function setValue($value)
    {
    	$this->_MyNode->nodeValue = $value;
 		return $this;
    }
    
   
}
