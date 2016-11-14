<?php
class B3it_XmlBind_Bmecat12_FeatureGroup extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var FeatureGroupId */
	private $_FeatureGroupId = null;	

	/* @var FeatureGroupName */
	private $_FeatureGroupName = null;	

	/* @var FeatureTemplate */
	private $_FeatureTemplates = array();	

	/* @var FeatureGroupDescr */
	private $_FeatureGroupDescr = null;	

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
	 * @return B3it_XmlBind_Bmecat12_FeatureGroupId
	 */
	public function getFeatureGroupId()
	{
		if($this->_FeatureGroupId == null)
		{
			$this->_FeatureGroupId = new B3it_XmlBind_Bmecat12_FeatureGroupId();
		}
		
		return $this->_FeatureGroupId;
	}
	
	/**
	 * @param $value FeatureGroupId
	 * @return B3it_XmlBind_Bmecat12_FeatureGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureGroupId($value)
	{
		$this->_FeatureGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FeatureGroupName
	 */
	public function getFeatureGroupName()
	{
		if($this->_FeatureGroupName == null)
		{
			$this->_FeatureGroupName = new B3it_XmlBind_Bmecat12_FeatureGroupName();
		}
		
		return $this->_FeatureGroupName;
	}
	
	/**
	 * @param $value FeatureGroupName
	 * @return B3it_XmlBind_Bmecat12_FeatureGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureGroupName($value)
	{
		$this->_FeatureGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FeatureTemplate[]
	 */
	public function getAllFeatureTemplate()
	{
		return $this->_FeatureTemplates;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_FeatureTemplate and add it to list
	 * @return B3it_XmlBind_Bmecat12_FeatureTemplate
	 */
	public function getFeatureTemplate()
	{
		$res = new B3it_XmlBind_Bmecat12_FeatureTemplate();
		$this->_FeatureTemplates[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FeatureTemplate[]
	 * @return B3it_XmlBind_Bmecat12_FeatureGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureTemplate($value)
	{
		$this->_FeatureTemplate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FeatureGroupDescr
	 */
	public function getFeatureGroupDescr()
	{
		if($this->_FeatureGroupDescr == null)
		{
			$this->_FeatureGroupDescr = new B3it_XmlBind_Bmecat12_FeatureGroupDescr();
		}
		
		return $this->_FeatureGroupDescr;
	}
	
	/**
	 * @param $value FeatureGroupDescr
	 * @return B3it_XmlBind_Bmecat12_FeatureGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureGroupDescr($value)
	{
		$this->_FeatureGroupDescr = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FEATURE_GROUP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FeatureGroupId != null){
			$this->_FeatureGroupId->toXml($xml);
		}
		if($this->_FeatureGroupName != null){
			$this->_FeatureGroupName->toXml($xml);
		}
		if($this->_FeatureTemplates != null){
			foreach($this->_FeatureTemplates as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FeatureGroupDescr != null){
			$this->_FeatureGroupDescr->toXml($xml);
		}


		return $xml;
	}
}