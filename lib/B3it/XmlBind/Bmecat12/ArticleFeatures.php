<?php
class B3it_XmlBind_Bmecat12_ArticleFeatures extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ReferenceFeatureSystemName */
	private $_ReferenceFeatureSystemName = null;	

	/* @var ReferenceFeatureGroupId */
	private $_ReferenceFeatureGroupId = null;	

	/* @var ReferenceFeatureGroupName */
	private $_ReferenceFeatureGroupName = null;	

	/* @var Feature */
	private $_Features = array();	

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
	 * @return B3it_XmlBind_Bmecat12_ReferenceFeatureSystemName
	 */
	public function getReferenceFeatureSystemName()
	{
		if($this->_ReferenceFeatureSystemName == null)
		{
			$this->_ReferenceFeatureSystemName = new B3it_XmlBind_Bmecat12_ReferenceFeatureSystemName();
		}
		
		return $this->_ReferenceFeatureSystemName;
	}
	
	/**
	 * @param $value ReferenceFeatureSystemName
	 * @return B3it_XmlBind_Bmecat12_ArticleFeatures extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setReferenceFeatureSystemName($value)
	{
		$this->_ReferenceFeatureSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ReferenceFeatureGroupId
	 */
	public function getReferenceFeatureGroupId()
	{
		if($this->_ReferenceFeatureGroupId == null)
		{
			$this->_ReferenceFeatureGroupId = new B3it_XmlBind_Bmecat12_ReferenceFeatureGroupId();
		}
		
		return $this->_ReferenceFeatureGroupId;
	}
	
	/**
	 * @param $value ReferenceFeatureGroupId
	 * @return B3it_XmlBind_Bmecat12_ArticleFeatures extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setReferenceFeatureGroupId($value)
	{
		$this->_ReferenceFeatureGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ReferenceFeatureGroupName
	 */
	public function getReferenceFeatureGroupName()
	{
		if($this->_ReferenceFeatureGroupName == null)
		{
			$this->_ReferenceFeatureGroupName = new B3it_XmlBind_Bmecat12_ReferenceFeatureGroupName();
		}
		
		return $this->_ReferenceFeatureGroupName;
	}
	
	/**
	 * @param $value ReferenceFeatureGroupName
	 * @return B3it_XmlBind_Bmecat12_ArticleFeatures extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setReferenceFeatureGroupName($value)
	{
		$this->_ReferenceFeatureGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Feature[]
	 */
	public function getAllFeature()
	{
		return $this->_Features;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Feature and add it to list
	 * @return B3it_XmlBind_Bmecat12_Feature
	 */
	public function getFeature()
	{
		$res = new B3it_XmlBind_Bmecat12_Feature();
		$this->_Features[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Feature[]
	 * @return B3it_XmlBind_Bmecat12_ArticleFeatures extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeature($value)
	{
		$this->_Feature = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_FEATURES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ReferenceFeatureSystemName != null){
			$this->_ReferenceFeatureSystemName->toXml($xml);
		}
		if($this->_ReferenceFeatureGroupId != null){
			$this->_ReferenceFeatureGroupId->toXml($xml);
		}
		if($this->_ReferenceFeatureGroupName != null){
			$this->_ReferenceFeatureGroupName->toXml($xml);
		}
		if($this->_Features != null){
			foreach($this->_Features as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}