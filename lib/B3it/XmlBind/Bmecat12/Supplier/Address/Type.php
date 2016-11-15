<?php
class B3it_XmlBind_Bmecat12_Supplier_Address_Type extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();


	public function getAttribute($name){
		if(isset($this->_attributes[$name])){
			 return $this->_attributes[$name];
		}
		return null;
	}

	public function setAttribute($name,$value){
		$this->_attributes[$name] = $value;
		return $this;
	}

	public function toXml($xml){
		return $xml;
	}
}