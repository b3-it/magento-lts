<?php
class B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ProdIdTo */
	private $_ProdIdTo = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var CatalogId */
	private $_CatalogId = null;	

	/* @var CatalogVersion */
	private $_CatalogVersion = null;	

	/* @var ReferenceDescr */
	private $_ReferenceDescrs = array();	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ProdIdTo
	 */
	public function getProdIdTo()
	{
		if($this->_ProdIdTo == null)
		{
			$this->_ProdIdTo = new B3it_XmlBind_Bmecat2005_ProdIdTo();
		}
		
		return $this->_ProdIdTo;
	}
	
	/**
	 * @param $value ProdIdTo
	 * @return B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProdIdTo($value)
	{
		$this->_ProdIdTo = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->_CatalogId == null)
		{
			$this->_CatalogId = new B3it_XmlBind_Bmecat2005_CatalogId();
		}
		
		return $this->_CatalogId;
	}
	
	/**
	 * @param $value CatalogId
	 * @return B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogId($value)
	{
		$this->_CatalogId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->_CatalogVersion == null)
		{
			$this->_CatalogVersion = new B3it_XmlBind_Bmecat2005_CatalogVersion();
		}
		
		return $this->_CatalogVersion;
	}
	
	/**
	 * @param $value CatalogVersion
	 * @return B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogVersion($value)
	{
		$this->_CatalogVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ReferenceDescr[]
	 */
	public function getAllReferenceDescr()
	{
		return $this->_ReferenceDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ReferenceDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ReferenceDescr
	 */
	public function getReferenceDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_ReferenceDescr();
		$this->_ReferenceDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ReferenceDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setReferenceDescr($value)
	{
		$this->_ReferenceDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_ProductReference extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_REFERENCE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ProdIdTo != null){
			$this->_ProdIdTo->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_CatalogId != null){
			$this->_CatalogId->toXml($xml);
		}
		if($this->_CatalogVersion != null){
			$this->_CatalogVersion->toXml($xml);
		}
		if($this->_ReferenceDescrs != null){
			foreach($this->_ReferenceDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}


		return $xml;
	}
}