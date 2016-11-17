<?php
class B3it_XmlBind_Bmecat12_ArticleReference extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ArtIdTo */
	private $_ArtIdTo = null;	

	/* @var CatalogId */
	private $_CatalogId = null;	

	/* @var CatalogVersion */
	private $_CatalogVersion = null;	

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
	 * @return B3it_XmlBind_Bmecat12_ArtIdTo
	 */
	public function getArtIdTo()
	{
		if($this->_ArtIdTo == null)
		{
			$this->_ArtIdTo = new B3it_XmlBind_Bmecat12_ArtIdTo();
		}
		
		return $this->_ArtIdTo;
	}
	
	/**
	 * @param $value ArtIdTo
	 * @return B3it_XmlBind_Bmecat12_ArticleReference extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setArtIdTo($value)
	{
		$this->_ArtIdTo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->_CatalogId == null)
		{
			$this->_CatalogId = new B3it_XmlBind_Bmecat12_CatalogId();
		}
		
		return $this->_CatalogId;
	}
	
	/**
	 * @param $value CatalogId
	 * @return B3it_XmlBind_Bmecat12_ArticleReference extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogId($value)
	{
		$this->_CatalogId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->_CatalogVersion == null)
		{
			$this->_CatalogVersion = new B3it_XmlBind_Bmecat12_CatalogVersion();
		}
		
		return $this->_CatalogVersion;
	}
	
	/**
	 * @param $value CatalogVersion
	 * @return B3it_XmlBind_Bmecat12_ArticleReference extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogVersion($value)
	{
		$this->_CatalogVersion = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_REFERENCE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ArtIdTo != null){
			$this->_ArtIdTo->toXml($xml);
		}
		if($this->_CatalogId != null){
			$this->_CatalogId->toXml($xml);
		}
		if($this->_CatalogVersion != null){
			$this->_CatalogVersion->toXml($xml);
		}


		return $xml;
	}
}