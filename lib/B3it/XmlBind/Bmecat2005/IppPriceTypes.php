<?php
class B3it_XmlBind_Bmecat2005_IppPriceTypes extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PriceType */
	private $_PriceTypes = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_PriceType[]
	 */
	public function getAllPriceType()
	{
		return $this->_PriceTypes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PriceType and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PriceType
	 */
	public function getPriceType()
	{
		$res = new B3it_XmlBind_Bmecat2005_PriceType();
		$this->_PriceTypes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PriceType[]
	 * @return B3it_XmlBind_Bmecat2005_IppPriceTypes extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceType($value)
	{
		$this->_PriceType = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_PRICE_TYPES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PriceTypes != null){
			foreach($this->_PriceTypes as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}