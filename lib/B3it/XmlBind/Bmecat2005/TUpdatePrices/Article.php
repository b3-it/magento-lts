<?php
class B3it_XmlBind_Bmecat2005_TUpdatePrices_Article extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SupplierAid */
	private $_SupplierAid = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var ArticlePriceDetails */
	private $_ArticlePriceDetailss = array();	

	/* @var UserDefinedExtensions */
	private $_UserDefinedExtensions = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_SupplierAid
	 */
	public function getSupplierAid()
	{
		if($this->_SupplierAid == null)
		{
			$this->_SupplierAid = new B3it_XmlBind_Bmecat2005_SupplierAid();
		}
		
		return $this->_SupplierAid;
	}
	
	/**
	 * @param $value SupplierAid
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierAid($value)
	{
		$this->_SupplierAid = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticlePriceDetails[]
	 */
	public function getAllArticlePriceDetails()
	{
		return $this->_ArticlePriceDetailss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ArticlePriceDetails and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ArticlePriceDetails
	 */
	public function getArticlePriceDetails()
	{
		$res = new B3it_XmlBind_Bmecat2005_ArticlePriceDetails();
		$this->_ArticlePriceDetailss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticlePriceDetails[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticlePriceDetails($value)
	{
		$this->_ArticlePriceDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat2005_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_SupplierAid != null){
			$this->_SupplierAid->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_ArticlePriceDetailss != null){
			foreach($this->_ArticlePriceDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}
}