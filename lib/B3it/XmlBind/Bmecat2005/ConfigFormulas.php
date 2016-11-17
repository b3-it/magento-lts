<?php
class B3it_XmlBind_Bmecat2005_ConfigFormulas extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ConfigFormula */
	private $_ConfigFormula = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ConfigFormula
	 */
	public function getConfigFormula()
	{
		if($this->_ConfigFormula == null)
		{
			$this->_ConfigFormula = new B3it_XmlBind_Bmecat2005_ConfigFormula();
		}
		
		return $this->_ConfigFormula;
	}
	
	/**
	 * @param $value ConfigFormula
	 * @return B3it_XmlBind_Bmecat2005_ConfigFormulas extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigFormula($value)
	{
		$this->_ConfigFormula = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CONFIG_FORMULAS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ConfigFormula != null){
			$this->_ConfigFormula->toXml($xml);
		}


		return $xml;
	}
}