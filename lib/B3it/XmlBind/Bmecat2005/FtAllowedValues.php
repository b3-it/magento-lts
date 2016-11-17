<?php
class B3it_XmlBind_Bmecat2005_FtAllowedValues extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AllowedValueIdref */
	private $_AllowedValueIdrefs = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueIdref[]
	 */
	public function getAllAllowedValueIdref()
	{
		return $this->_AllowedValueIdrefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AllowedValueIdref and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueIdref
	 */
	public function getAllowedValueIdref()
	{
		$res = new B3it_XmlBind_Bmecat2005_AllowedValueIdref();
		$this->_AllowedValueIdrefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AllowedValueIdref[]
	 * @return B3it_XmlBind_Bmecat2005_FtAllowedValues extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueIdref($value)
	{
		$this->_AllowedValueIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_ALLOWED_VALUES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AllowedValueIdrefs != null){
			foreach($this->_AllowedValueIdrefs as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}