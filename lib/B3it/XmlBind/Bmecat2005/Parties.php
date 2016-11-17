<?php
class B3it_XmlBind_Bmecat2005_Parties extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Party */
	private $_Partys = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Party[]
	 */
	public function getAllParty()
	{
		return $this->_Partys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Party and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Party
	 */
	public function getParty()
	{
		$res = new B3it_XmlBind_Bmecat2005_Party();
		$this->_Partys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Party[]
	 * @return B3it_XmlBind_Bmecat2005_Parties extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParty($value)
	{
		$this->_Party = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARTIES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Partys != null){
			foreach($this->_Partys as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}