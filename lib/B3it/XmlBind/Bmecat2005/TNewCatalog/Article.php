<?php
class B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SupplierAid */
	private $_SupplierAid = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var ArticleDetails */
	private $_ArticleDetails = null;	

	/* @var ArticleFeatures */
	private $_ArticleFeaturess = array();	

	/* @var ArticleOrderDetails */
	private $_ArticleOrderDetails = null;	

	/* @var ArticlePriceDetails */
	private $_ArticlePriceDetailss = array();	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var UserDefinedExtensions */
	private $_UserDefinedExtensions = null;	

	/* @var ArticleReference */
	private $_ArticleReferences = array();	

	/* @var ArticleContacts */
	private $_ArticleContacts = null;	

	/* @var ArticleLogisticDetails */
	private $_ArticleLogisticDetails = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleDetails
	 */
	public function getArticleDetails()
	{
		if($this->_ArticleDetails == null)
		{
			$this->_ArticleDetails = new B3it_XmlBind_Bmecat2005_ArticleDetails();
		}
		
		return $this->_ArticleDetails;
	}
	
	/**
	 * @param $value ArticleDetails
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleDetails($value)
	{
		$this->_ArticleDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures[]
	 */
	public function getAllArticleFeatures()
	{
		return $this->_ArticleFeaturess;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ArticleFeatures and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ArticleFeatures
	 */
	public function getArticleFeatures()
	{
		$res = new B3it_XmlBind_Bmecat2005_ArticleFeatures();
		$this->_ArticleFeaturess[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleFeatures[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleFeatures($value)
	{
		$this->_ArticleFeatures = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleOrderDetails
	 */
	public function getArticleOrderDetails()
	{
		if($this->_ArticleOrderDetails == null)
		{
			$this->_ArticleOrderDetails = new B3it_XmlBind_Bmecat2005_ArticleOrderDetails();
		}
		
		return $this->_ArticleOrderDetails;
	}
	
	/**
	 * @param $value ArticleOrderDetails
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleOrderDetails($value)
	{
		$this->_ArticleOrderDetails = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticlePriceDetails($value)
	{
		$this->_ArticlePriceDetails = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleReference[]
	 */
	public function getAllArticleReference()
	{
		return $this->_ArticleReferences;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ArticleReference and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ArticleReference
	 */
	public function getArticleReference()
	{
		$res = new B3it_XmlBind_Bmecat2005_ArticleReference();
		$this->_ArticleReferences[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleReference[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleReference($value)
	{
		$this->_ArticleReference = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleContacts
	 */
	public function getArticleContacts()
	{
		if($this->_ArticleContacts == null)
		{
			$this->_ArticleContacts = new B3it_XmlBind_Bmecat2005_ArticleContacts();
		}
		
		return $this->_ArticleContacts;
	}
	
	/**
	 * @param $value ArticleContacts
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleContacts($value)
	{
		$this->_ArticleContacts = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails
	 */
	public function getArticleLogisticDetails()
	{
		if($this->_ArticleLogisticDetails == null)
		{
			$this->_ArticleLogisticDetails = new B3it_XmlBind_Bmecat2005_ArticleLogisticDetails();
		}
		
		return $this->_ArticleLogisticDetails;
	}
	
	/**
	 * @param $value ArticleLogisticDetails
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleLogisticDetails($value)
	{
		$this->_ArticleLogisticDetails = $value;
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
		if($this->_ArticleDetails != null){
			$this->_ArticleDetails->toXml($xml);
		}
		if($this->_ArticleFeaturess != null){
			foreach($this->_ArticleFeaturess as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ArticleOrderDetails != null){
			$this->_ArticleOrderDetails->toXml($xml);
		}
		if($this->_ArticlePriceDetailss != null){
			foreach($this->_ArticlePriceDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}
		if($this->_ArticleReferences != null){
			foreach($this->_ArticleReferences as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ArticleContacts != null){
			$this->_ArticleContacts->toXml($xml);
		}
		if($this->_ArticleLogisticDetails != null){
			$this->_ArticleLogisticDetails->toXml($xml);
		}


		return $xml;
	}
}