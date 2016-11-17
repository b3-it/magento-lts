<?php
class B3it_XmlBind_Bmecat2005_AllowedValueSynonyms extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Synonym */
	private $_Synonyms = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Synonym[]
	 */
	public function getAllSynonym()
	{
		return $this->_Synonyms;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Synonym and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Synonym
	 */
	public function getSynonym()
	{
		$res = new B3it_XmlBind_Bmecat2005_Synonym();
		$this->_Synonyms[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Synonym[]
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueSynonyms extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSynonym($value)
	{
		$this->_Synonym = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ALLOWED_VALUE_SYNONYMS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Synonyms != null){
			foreach($this->_Synonyms as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}