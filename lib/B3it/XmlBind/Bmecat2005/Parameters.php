<?php
class B3it_XmlBind_Bmecat2005_Parameters extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Parameter */
	private $_Parameters = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Parameter[]
	 */
	public function getAllParameter()
	{
		return $this->_Parameters;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Parameter and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Parameter
	 */
	public function getParameter()
	{
		$res = new B3it_XmlBind_Bmecat2005_Parameter();
		$this->_Parameters[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Parameter[]
	 * @return B3it_XmlBind_Bmecat2005_Parameters extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameter($value)
	{
		$this->_Parameter = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARAMETERS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Parameters != null){
			foreach($this->_Parameters as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}