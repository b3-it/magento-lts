<?php
class B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ReferenceFeatureSystemName */
	private $_ReferenceFeatureSystemName = null;	

	/* @var ReferenceFeatureGroupId */
	private $_ReferenceFeatureGroupIds = array();	

	/* @var ReferenceFeatureGroupName */
	private $_ReferenceFeatureGroupNames = array();	

	/* @var ReferenceFeatureGroupId2 */
	private $_ReferenceFeatureGroupId2s = array();	

	/* @var ClassificationGroupArticleorder */
	private $_ClassificationGroupArticleorder = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureSystemName
	 */
	public function getReferenceFeatureSystemName()
	{
		if($this->_ReferenceFeatureSystemName == null)
		{
			$this->_ReferenceFeatureSystemName = new B3it_XmlBind_Bmecat2005_ReferenceFeatureSystemName();
		}
		
		return $this->_ReferenceFeatureSystemName;
	}
	
	/**
	 * @param $value ReferenceFeatureSystemName
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setReferenceFeatureSystemName($value)
	{
		$this->_ReferenceFeatureSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId[]
	 */
	public function getAllReferenceFeatureGroupId()
	{
		return $this->_ReferenceFeatureGroupIds;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId
	 */
	public function getReferenceFeatureGroupId()
	{
		$res = new B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId();
		$this->_ReferenceFeatureGroupIds[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ReferenceFeatureGroupId[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setReferenceFeatureGroupId($value)
	{
		$this->_ReferenceFeatureGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupName[]
	 */
	public function getAllReferenceFeatureGroupName()
	{
		return $this->_ReferenceFeatureGroupNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupName
	 */
	public function getReferenceFeatureGroupName()
	{
		$res = new B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupName();
		$this->_ReferenceFeatureGroupNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ReferenceFeatureGroupName[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setReferenceFeatureGroupName($value)
	{
		$this->_ReferenceFeatureGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId2[]
	 */
	public function getAllReferenceFeatureGroupId2()
	{
		return $this->_ReferenceFeatureGroupId2s;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId2 and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId2
	 */
	public function getReferenceFeatureGroupId2()
	{
		$res = new B3it_XmlBind_Bmecat2005_ReferenceFeatureGroupId2();
		$this->_ReferenceFeatureGroupId2s[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ReferenceFeatureGroupId2[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setReferenceFeatureGroupId2($value)
	{
		$this->_ReferenceFeatureGroupId2 = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupArticleorder
	 */
	public function getClassificationGroupArticleorder()
	{
		if($this->_ClassificationGroupArticleorder == null)
		{
			$this->_ClassificationGroupArticleorder = new B3it_XmlBind_Bmecat2005_ClassificationGroupArticleorder();
		}
		
		return $this->_ClassificationGroupArticleorder;
	}
	
	/**
	 * @param $value ClassificationGroupArticleorder
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupArticleorder($value)
	{
		$this->_ClassificationGroupArticleorder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Feature[]
	 */
	public function getAllFeature()
	{
		return $this->_Features;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Feature and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Feature
	 */
	public function getFeature()
	{
		$res = new B3it_XmlBind_Bmecat2005_Feature();
		$this->_Features[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Feature[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures extends B3it_XmlBind_Bmecat2005_XmlBind
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
		if($this->_ReferenceFeatureGroupIds != null){
			foreach($this->_ReferenceFeatureGroupIds as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ReferenceFeatureGroupNames != null){
			foreach($this->_ReferenceFeatureGroupNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ReferenceFeatureGroupId2s != null){
			foreach($this->_ReferenceFeatureGroupId2s as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationGroupArticleorder != null){
			$this->_ClassificationGroupArticleorder->toXml($xml);
		}
		if($this->_Features != null){
			foreach($this->_Features as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}