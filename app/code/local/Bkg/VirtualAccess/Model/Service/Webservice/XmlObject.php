<?php


class Bkg_VirtualAccess_Model_Service_Webservice_XmlObject extends Bkg_VirtualAccess_Model_Service_Webservice_XmlBind 
{

	private $_value = '';
	
	private $__attributes = array();
	
	public function getAttribute($name){
		if(isset($this->__attributes[$name])){
			return $this->__attributes[$name];
		}
		return null;
	}
	
	public function setAttribute($name,$value){
		$this->__attributes[$name] = $value;
		return $this;
	}
	
	public function getAttributes()
	{
		return $this->__attributes;
	}
	
	public function getValue(){
		return $this->_value;
	}
	
	public function setValue($value){
		$this->_value = $value;
		return $this->_value;
	}
	
	public function addValueToXml($xml)
	{
		$xml->nodeValue = html_entity_decode($this->getValue(),ENT_XHTML,'UTF-8');
		return $xml;
	}
}