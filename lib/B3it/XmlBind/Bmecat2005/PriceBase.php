<?php
class B3it_XmlBind_Bmecat2005_PriceBase extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PriceUnit */
	private $_PriceUnit = null;	

	/* @var PriceUnitFactor */
	private $_PriceUnitFactor = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PriceUnit
	 */
	public function getPriceUnit()
	{
		if($this->_PriceUnit == null)
		{
			$this->_PriceUnit = new B3it_XmlBind_Bmecat2005_PriceUnit();
		}
		
		return $this->_PriceUnit;
	}
	
	/**
	 * @param $value PriceUnit
	 * @return B3it_XmlBind_Bmecat2005_PriceBase extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceUnit($value)
	{
		$this->_PriceUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceUnitFactor
	 */
	public function getPriceUnitFactor()
	{
		if($this->_PriceUnitFactor == null)
		{
			$this->_PriceUnitFactor = new B3it_XmlBind_Bmecat2005_PriceUnitFactor();
		}
		
		return $this->_PriceUnitFactor;
	}
	
	/**
	 * @param $value PriceUnitFactor
	 * @return B3it_XmlBind_Bmecat2005_PriceBase extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceUnitFactor($value)
	{
		$this->_PriceUnitFactor = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRICE_BASE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PriceUnit != null){
			$this->_PriceUnit->toXml($xml);
		}
		if($this->_PriceUnitFactor != null){
			$this->_PriceUnitFactor->toXml($xml);
		}


		return $xml;
	}
}