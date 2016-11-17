<?php
class B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ProdId */
	private $_ProdId = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var CatalogGroupId */
	private $_CatalogGroupId = null;	

	/* @var ProductToCataloggroupMapOrder */
	private $_ProductToCataloggroupMapOrder = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ProdId
	 */
	public function getProdId()
	{
		if($this->_ProdId == null)
		{
			$this->_ProdId = new B3it_XmlBind_Bmecat2005_ProdId();
		}
		
		return $this->_ProdId;
	}
	
	/**
	 * @param $value ProdId
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProdId($value)
	{
		$this->_ProdId = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogGroupId($value)
	{
		$this->_CatalogGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductToCataloggroupMapOrder
	 */
	public function getProductToCataloggroupMapOrder()
	{
		if($this->_ProductToCataloggroupMapOrder == null)
		{
			$this->_ProductToCataloggroupMapOrder = new B3it_XmlBind_Bmecat2005_ProductToCataloggroupMapOrder();
		}
		
		return $this->_ProductToCataloggroupMapOrder;
	}
	
	/**
	 * @param $value ProductToCataloggroupMapOrder
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductToCataloggroupMapOrder($value)
	{
		$this->_ProductToCataloggroupMapOrder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_TO_CATALOGGROUP_MAP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ProdId != null){
			$this->_ProdId->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_CatalogGroupId != null){
			$this->_CatalogGroupId->toXml($xml);
		}
		if($this->_ProductToCataloggroupMapOrder != null){
			$this->_ProductToCataloggroupMapOrder->toXml($xml);
		}


		return $xml;
	}
}