<?php
class B3it_XmlBind_Bmecat2005_FormulaFunction extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Term */
	private $_Terms = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Term[]
	 */
	public function getAllTerm()
	{
		return $this->_Terms;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Term and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Term
	 */
	public function getTerm()
	{
		$res = new B3it_XmlBind_Bmecat2005_Term();
		$this->_Terms[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Term[]
	 * @return B3it_XmlBind_Bmecat2005_FormulaFunction extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTerm($value)
	{
		$this->_Term = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FORMULA_FUNCTION');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Terms != null){
			foreach($this->_Terms as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}