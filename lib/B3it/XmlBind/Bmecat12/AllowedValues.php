<?php
class B3it_XmlBind_Bmecat12_AllowedValues extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var AllowedValue */
	private $_AllowedValues = array();	

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



	/**
	 * @return B3it_XmlBind_Bmecat12_AllowedValue[]
	 */
	public function getAllAllowedValue()
	{
		return $this->_AllowedValues;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_AllowedValue and add it to list
	 * @return B3it_XmlBind_Bmecat12_AllowedValue
	 */
	public function getAllowedValue()
	{
		$res = new B3it_XmlBind_Bmecat12_AllowedValue();
		$this->_AllowedValues[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AllowedValue[]
	 * @return B3it_XmlBind_Bmecat12_AllowedValues extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAllowedValue($value)
	{
		$this->_AllowedValue = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ALLOWED_VALUES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AllowedValues != null){
			foreach($this->_AllowedValues as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}