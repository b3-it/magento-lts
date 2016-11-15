<?php
class B3it_XmlBind_Bmecat12_Units extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Unit */
	private $_Units = array();	

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
	 * @return B3it_XmlBind_Bmecat12_Unit[]
	 */
	public function getAllUnit()
	{
		return $this->_Units;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Unit and add it to list
	 * @return B3it_XmlBind_Bmecat12_Unit
	 */
	public function getUnit()
	{
		$res = new B3it_XmlBind_Bmecat12_Unit();
		$this->_Units[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Unit[]
	 * @return B3it_XmlBind_Bmecat12_Units extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUnit($value)
	{
		$this->_Unit = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('UNITS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Units != null){
			foreach($this->_Units as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}