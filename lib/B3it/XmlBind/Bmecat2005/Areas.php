<?php
class B3it_XmlBind_Bmecat2005_Areas extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Area */
	private $_Areas = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Area[]
	 */
	public function getAllArea()
	{
		return $this->_Areas;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Area and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Area
	 */
	public function getArea()
	{
		$res = new B3it_XmlBind_Bmecat2005_Area();
		$this->_Areas[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Area[]
	 * @return B3it_XmlBind_Bmecat2005_Areas extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArea($value)
	{
		$this->_Area = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AREAS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Areas != null){
			foreach($this->_Areas as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}