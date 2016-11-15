<?php
class B3it_XmlBind_Bmecat12_FeatureSystem extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var FeatureSystemName */
	private $_FeatureSystemName = null;	

	/* @var FeatureSystemDescr */
	private $_FeatureSystemDescr = null;	

	/* @var FeatureGroup */
	private $_FeatureGroups = array();	

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
	 * @return B3it_XmlBind_Bmecat12_FeatureSystemName
	 */
	public function getFeatureSystemName()
	{
		if($this->_FeatureSystemName == null)
		{
			$this->_FeatureSystemName = new B3it_XmlBind_Bmecat12_FeatureSystemName();
		}
		
		return $this->_FeatureSystemName;
	}
	
	/**
	 * @param $value FeatureSystemName
	 * @return B3it_XmlBind_Bmecat12_FeatureSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureSystemName($value)
	{
		$this->_FeatureSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FeatureSystemDescr
	 */
	public function getFeatureSystemDescr()
	{
		if($this->_FeatureSystemDescr == null)
		{
			$this->_FeatureSystemDescr = new B3it_XmlBind_Bmecat12_FeatureSystemDescr();
		}
		
		return $this->_FeatureSystemDescr;
	}
	
	/**
	 * @param $value FeatureSystemDescr
	 * @return B3it_XmlBind_Bmecat12_FeatureSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureSystemDescr($value)
	{
		$this->_FeatureSystemDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FeatureGroup[]
	 */
	public function getAllFeatureGroup()
	{
		return $this->_FeatureGroups;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_FeatureGroup and add it to list
	 * @return B3it_XmlBind_Bmecat12_FeatureGroup
	 */
	public function getFeatureGroup()
	{
		$res = new B3it_XmlBind_Bmecat12_FeatureGroup();
		$this->_FeatureGroups[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FeatureGroup[]
	 * @return B3it_XmlBind_Bmecat12_FeatureSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureGroup($value)
	{
		$this->_FeatureGroup = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FEATURE_SYSTEM');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FeatureSystemName != null){
			$this->_FeatureSystemName->toXml($xml);
		}
		if($this->_FeatureSystemDescr != null){
			$this->_FeatureSystemDescr->toXml($xml);
		}
		if($this->_FeatureGroups != null){
			foreach($this->_FeatureGroups as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}