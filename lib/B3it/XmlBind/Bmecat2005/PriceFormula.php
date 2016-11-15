<?php
class B3it_XmlBind_Bmecat2005_PriceFormula extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FormulaIdref */
	private $_FormulaIdref = null;	

	/* @var Parameters */
	private $_Parameters = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_FormulaIdref
	 */
	public function getFormulaIdref()
	{
		if($this->_FormulaIdref == null)
		{
			$this->_FormulaIdref = new B3it_XmlBind_Bmecat2005_FormulaIdref();
		}
		
		return $this->_FormulaIdref;
	}
	
	/**
	 * @param $value FormulaIdref
	 * @return B3it_XmlBind_Bmecat2005_PriceFormula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaIdref($value)
	{
		$this->_FormulaIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Parameters
	 */
	public function getParameters()
	{
		if($this->_Parameters == null)
		{
			$this->_Parameters = new B3it_XmlBind_Bmecat2005_Parameters();
		}
		
		return $this->_Parameters;
	}
	
	/**
	 * @param $value Parameters
	 * @return B3it_XmlBind_Bmecat2005_PriceFormula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameters($value)
	{
		$this->_Parameters = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRICE_FORMULA');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FormulaIdref != null){
			$this->_FormulaIdref->toXml($xml);
		}
		if($this->_Parameters != null){
			$this->_Parameters->toXml($xml);
		}


		return $xml;
	}
}