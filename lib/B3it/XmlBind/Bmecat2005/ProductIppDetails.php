<?php
class B3it_XmlBind_Bmecat2005_ProductIppDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Ipp */
	private $_Ipps = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Ipp[]
	 */
	public function getAllIpp()
	{
		return $this->_Ipps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Ipp and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Ipp
	 */
	public function getIpp()
	{
		$res = new B3it_XmlBind_Bmecat2005_Ipp();
		$this->_Ipps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Ipp[]
	 * @return B3it_XmlBind_Bmecat2005_ProductIppDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIpp($value)
	{
		$this->_Ipp = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_IPP_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Ipps != null){
			foreach($this->_Ipps as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}