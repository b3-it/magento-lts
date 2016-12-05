<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TNewCatalog_Bmecat_Article
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierAid */
	private $__SupplierAid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails */
	private $__ArticleDetails = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleFeatures */
	private $__ArticleFeaturesA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails */
	private $__ArticleOrderDetails = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails */
	private $__ArticlePriceDetailsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions */
	private $__UserDefinedExtensions = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleReference */
	private $__ArticleReferenceA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleContacts */
	private $__ArticleContacts = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticleLogisticDetails */
	private $__ArticleLogisticDetails = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierAid
	 */
	public function getSupplierAid()
	{
		if($this->__SupplierAid == null)
		{
			$this->__SupplierAid = new B3it_XmlBind_Opentrans21_Bmecat_SupplierAid();
		}
	
		return $this->__SupplierAid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierAid
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setSupplierAid($value)
	{
		$this->__SupplierAid = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->__SupplierIdref == null)
		{
			$this->__SupplierIdref = new B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref();
		}
	
		return $this->__SupplierIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 */
	public function getArticleDetails()
	{
		if($this->__ArticleDetails == null)
		{
			$this->__ArticleDetails = new B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails();
		}
	
		return $this->__ArticleDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleDetails
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticleDetails($value)
	{
		$this->__ArticleDetails = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticleFeatures and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleFeatures
	 */
	public function getArticleFeatures()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticleFeatures();
		$this->__ArticleFeaturesA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleFeatures
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticleFeatures($value)
	{
		$this->__ArticleFeaturesA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleFeatures[]
	 */
	public function getAllArticleFeatures()
	{
		return $this->__ArticleFeaturesA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 */
	public function getArticleOrderDetails()
	{
		if($this->__ArticleOrderDetails == null)
		{
			$this->__ArticleOrderDetails = new B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails();
		}
	
		return $this->__ArticleOrderDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleOrderDetails
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticleOrderDetails($value)
	{
		$this->__ArticleOrderDetails = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function getArticlePriceDetails()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails();
		$this->__ArticlePriceDetailsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticlePriceDetails($value)
	{
		$this->__ArticlePriceDetailsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails[]
	 */
	public function getAllArticlePriceDetails()
	{
		return $this->__ArticlePriceDetailsA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->__UserDefinedExtensions == null)
		{
			$this->__UserDefinedExtensions = new B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions();
		}
	
		return $this->__UserDefinedExtensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UserDefinedExtensions
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->__UserDefinedExtensions = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticleReference and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
	 */
	public function getArticleReference()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticleReference();
		$this->__ArticleReferenceA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleReference
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticleReference($value)
	{
		$this->__ArticleReferenceA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleReference[]
	 */
	public function getAllArticleReference()
	{
		return $this->__ArticleReferenceA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleContacts
	 */
	public function getArticleContacts()
	{
		if($this->__ArticleContacts == null)
		{
			$this->__ArticleContacts = new B3it_XmlBind_Opentrans21_Bmecat_ArticleContacts();
		}
	
		return $this->__ArticleContacts;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleContacts
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticleContacts($value)
	{
		$this->__ArticleContacts = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticleLogisticDetails
	 */
	public function getArticleLogisticDetails()
	{
		if($this->__ArticleLogisticDetails == null)
		{
			$this->__ArticleLogisticDetails = new B3it_XmlBind_Opentrans21_Bmecat_ArticleLogisticDetails();
		}
	
		return $this->__ArticleLogisticDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticleLogisticDetails
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function setArticleLogisticDetails($value)
	{
		$this->__ArticleLogisticDetails = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SupplierAid != null){
			$this->__SupplierAid->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__ArticleDetails != null){
			$this->__ArticleDetails->toXml($xml);
		}
		if($this->__ArticleFeaturesA != null){
			foreach($this->__ArticleFeaturesA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ArticleOrderDetails != null){
			$this->__ArticleOrderDetails->toXml($xml);
		}
		if($this->__ArticlePriceDetailsA != null){
			foreach($this->__ArticlePriceDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__UserDefinedExtensions != null){
			$this->__UserDefinedExtensions->toXml($xml);
		}
		if($this->__ArticleReferenceA != null){
			foreach($this->__ArticleReferenceA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ArticleContacts != null){
			$this->__ArticleContacts->toXml($xml);
		}
		if($this->__ArticleLogisticDetails != null){
			$this->__ArticleLogisticDetails->toXml($xml);
		}


		return $xml;
	}

}
