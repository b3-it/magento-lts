<?php
class B3it_XmlBind_Bmecat2005_IppLanguages extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Language */
	private $_Languages = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Language[]
	 */
	public function getAllLanguage()
	{
		return $this->_Languages;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Language and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Language
	 */
	public function getLanguage()
	{
		$res = new B3it_XmlBind_Bmecat2005_Language();
		$this->_Languages[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Language[]
	 * @return B3it_XmlBind_Bmecat2005_IppLanguages extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLanguage($value)
	{
		$this->_Language = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_LANGUAGES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Languages != null){
			foreach($this->_Languages as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}