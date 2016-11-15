<?php
class B3it_XmlBind_Bmecat2005_AreaRefs extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AreaIdref */
	private $_AreaIdrefs = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_AreaIdref[]
	 */
	public function getAllAreaIdref()
	{
		return $this->_AreaIdrefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AreaIdref and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AreaIdref
	 */
	public function getAreaIdref()
	{
		$res = new B3it_XmlBind_Bmecat2005_AreaIdref();
		$this->_AreaIdrefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AreaIdref[]
	 * @return B3it_XmlBind_Bmecat2005_AreaRefs extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaIdref($value)
	{
		$this->_AreaIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AREA_REFS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AreaIdrefs != null){
			foreach($this->_AreaIdrefs as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}