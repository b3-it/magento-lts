<?php
class B3it_XmlBind_Bmecat12_ClassificationSystemLevelNames extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationSystemLevelName */
	private $_ClassificationSystemLevelNames = array();	

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
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemLevelName[]
	 */
	public function getAllClassificationSystemLevelName()
	{
		return $this->_ClassificationSystemLevelNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ClassificationSystemLevelName and add it to list
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemLevelName
	 */
	public function getClassificationSystemLevelName()
	{
		$res = new B3it_XmlBind_Bmecat12_ClassificationSystemLevelName();
		$this->_ClassificationSystemLevelNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationSystemLevelName[]
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemLevelNames extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemLevelName($value)
	{
		$this->_ClassificationSystemLevelName = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_SYSTEM_LEVEL_NAMES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationSystemLevelNames != null){
			foreach($this->_ClassificationSystemLevelNames as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}