<?php
class B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ArtId */
	private $_ArtId = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var CatalogGroupId */
	private $_CatalogGroupId = null;	

	/* @var ArticleToCataloggroupMapOrder */
	private $_ArticleToCataloggroupMapOrder = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ArtId
	 */
	public function getArtId()
	{
		if($this->_ArtId == null)
		{
			$this->_ArtId = new B3it_XmlBind_Bmecat2005_ArtId();
		}
		
		return $this->_ArtId;
	}
	
	/**
	 * @param $value ArtId
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArtId($value)
	{
		$this->_ArtId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->_SupplierIdref == null)
		{
			$this->_SupplierIdref = new B3it_XmlBind_Bmecat2005_SupplierIdref();
		}
		
		return $this->_SupplierIdref;
	}
	
	/**
	 * @param $value SupplierIdref
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogGroupId
	 */
	public function getCatalogGroupId()
	{
		if($this->_CatalogGroupId == null)
		{
			$this->_CatalogGroupId = new B3it_XmlBind_Bmecat2005_CatalogGroupId();
		}
		
		return $this->_CatalogGroupId;
	}
	
	/**
	 * @param $value CatalogGroupId
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogGroupId($value)
	{
		$this->_CatalogGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleToCataloggroupMapOrder
	 */
	public function getArticleToCataloggroupMapOrder()
	{
		if($this->_ArticleToCataloggroupMapOrder == null)
		{
			$this->_ArticleToCataloggroupMapOrder = new B3it_XmlBind_Bmecat2005_ArticleToCataloggroupMapOrder();
		}
		
		return $this->_ArticleToCataloggroupMapOrder;
	}
	
	/**
	 * @param $value ArticleToCataloggroupMapOrder
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleToCataloggroupMapOrder($value)
	{
		$this->_ArticleToCataloggroupMapOrder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_TO_CATALOGGROUP_MAP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ArtId != null){
			$this->_ArtId->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_CatalogGroupId != null){
			$this->_CatalogGroupId->toXml($xml);
		}
		if($this->_ArticleToCataloggroupMapOrder != null){
			$this->_ArticleToCataloggroupMapOrder->toXml($xml);
		}


		return $xml;
	}
}