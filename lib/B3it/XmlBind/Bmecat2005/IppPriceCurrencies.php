<?php
class B3it_XmlBind_Bmecat2005_IppPriceCurrencies extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PriceCurrency */
	private $_PriceCurrencys = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_PriceCurrency[]
	 */
	public function getAllPriceCurrency()
	{
		return $this->_PriceCurrencys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PriceCurrency and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PriceCurrency
	 */
	public function getPriceCurrency()
	{
		$res = new B3it_XmlBind_Bmecat2005_PriceCurrency();
		$this->_PriceCurrencys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PriceCurrency[]
	 * @return B3it_XmlBind_Bmecat2005_IppPriceCurrencies extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceCurrency($value)
	{
		$this->_PriceCurrency = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_PRICE_CURRENCIES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PriceCurrencys != null){
			foreach($this->_PriceCurrencys as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}