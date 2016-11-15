<?php
class B3it_XmlBind_Bmecat2005_Formulas extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Formula */
	private $_Formulas = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Formula[]
	 */
	public function getAllFormula()
	{
		return $this->_Formulas;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Formula and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Formula
	 */
	public function getFormula()
	{
		$res = new B3it_XmlBind_Bmecat2005_Formula();
		$this->_Formulas[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Formula[]
	 * @return B3it_XmlBind_Bmecat2005_Formulas extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormula($value)
	{
		$this->_Formula = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FORMULAS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Formulas != null){
			foreach($this->_Formulas as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}