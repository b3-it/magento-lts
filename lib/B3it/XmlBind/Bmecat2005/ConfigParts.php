<?php
class B3it_XmlBind_Bmecat2005_ConfigParts extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PartAlternative */
	private $_PartAlternatives = array();	

	/* @var PartSelectionType */
	private $_PartSelectionType = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative[]
	 */
	public function getAllPartAlternative()
	{
		return $this->_PartAlternatives;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PartAlternative and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative
	 */
	public function getPartAlternative()
	{
		$res = new B3it_XmlBind_Bmecat2005_PartAlternative();
		$this->_PartAlternatives[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PartAlternative[]
	 * @return B3it_XmlBind_Bmecat2005_ConfigParts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPartAlternative($value)
	{
		$this->_PartAlternative = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PartSelectionType
	 */
	public function getPartSelectionType()
	{
		if($this->_PartSelectionType == null)
		{
			$this->_PartSelectionType = new B3it_XmlBind_Bmecat2005_PartSelectionType();
		}
		
		return $this->_PartSelectionType;
	}
	
	/**
	 * @param $value PartSelectionType
	 * @return B3it_XmlBind_Bmecat2005_ConfigParts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPartSelectionType($value)
	{
		$this->_PartSelectionType = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CONFIG_PARTS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PartAlternatives != null){
			foreach($this->_PartAlternatives as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PartSelectionType != null){
			$this->_PartSelectionType->toXml($xml);
		}


		return $xml;
	}
}