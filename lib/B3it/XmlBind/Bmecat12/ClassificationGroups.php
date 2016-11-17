<?php
class B3it_XmlBind_Bmecat12_ClassificationGroups extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationGroup */
	private $_ClassificationGroups = array();	

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
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup[]
	 */
	public function getAllClassificationGroup()
	{
		return $this->_ClassificationGroups;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ClassificationGroup and add it to list
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup
	 */
	public function getClassificationGroup()
	{
		$res = new B3it_XmlBind_Bmecat12_ClassificationGroup();
		$this->_ClassificationGroups[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroup[]
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroups extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroup($value)
	{
		$this->_ClassificationGroup = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_GROUPS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationGroups != null){
			foreach($this->_ClassificationGroups as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}