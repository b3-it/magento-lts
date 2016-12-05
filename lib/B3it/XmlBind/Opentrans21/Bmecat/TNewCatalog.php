<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_TNewCatalog
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FeatureSystem */
	private $__FeatureSystem = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem */
	private $__ClassificationSystemA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem */
	private $__CatalogGroupSystem = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Formulas */
	private $__Formulas = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppDefinitions */
	private $__IppDefinitions = null;

	
	/* @var B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Product */
	private $__ProductA = array();

	
	/* @var B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap */
	private $__ProductToCataloggroupMapA = array();

	
	/* @var B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article */
	private $__ArticleA = array();

	
	/* @var B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ArticleToCataloggroupMap */
	private $__ArticleToCataloggroupMapA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FeatureSystem
	 */
	public function getFeatureSystem()
	{
		if($this->__FeatureSystem == null)
		{
			$this->__FeatureSystem = new B3it_XmlBind_Opentrans21_Bmecat_FeatureSystem();
		}
	
		return $this->__FeatureSystem;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FeatureSystem
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setFeatureSystem($value)
	{
		$this->__FeatureSystem = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function getClassificationSystem()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem();
		$this->__ClassificationSystemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setClassificationSystem($value)
	{
		$this->__ClassificationSystemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem[]
	 */
	public function getAllClassificationSystem()
	{
		return $this->__ClassificationSystemA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem
	 */
	public function getCatalogGroupSystem()
	{
		if($this->__CatalogGroupSystem == null)
		{
			$this->__CatalogGroupSystem = new B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem();
		}
	
		return $this->__CatalogGroupSystem;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setCatalogGroupSystem($value)
	{
		$this->__CatalogGroupSystem = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formulas
	 */
	public function getFormulas()
	{
		if($this->__Formulas == null)
		{
			$this->__Formulas = new B3it_XmlBind_Opentrans21_Bmecat_Formulas();
		}
	
		return $this->__Formulas;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Formulas
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setFormulas($value)
	{
		$this->__Formulas = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinitions
	 */
	public function getIppDefinitions()
	{
		if($this->__IppDefinitions == null)
		{
			$this->__IppDefinitions = new B3it_XmlBind_Opentrans21_Bmecat_IppDefinitions();
		}
	
		return $this->__IppDefinitions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppDefinitions
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setIppDefinitions($value)
	{
		$this->__IppDefinitions = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Product and add it to list
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Product
	 */
	public function getProduct()
	{
		$res = new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Product();
		$this->__ProductA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Product
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setProduct($value)
	{
		$this->__ProductA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Product[]
	 */
	public function getAllProduct()
	{
		return $this->__ProductA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap
	 */
	public function getProductToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap();
		$this->__ProductToCataloggroupMapA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setProductToCataloggroupMap($value)
	{
		$this->__ProductToCataloggroupMapA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ProductToCataloggroupMap[]
	 */
	public function getAllProductToCataloggroupMap()
	{
		return $this->__ProductToCataloggroupMapA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article and add it to list
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 */
	public function getArticle()
	{
		$res = new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article();
		$this->__ArticleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setArticle($value)
	{
		$this->__ArticleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_Article[]
	 */
	public function getAllArticle()
	{
		return $this->__ArticleA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ArticleToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ArticleToCataloggroupMap
	 */
	public function getArticleToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ArticleToCataloggroupMap();
		$this->__ArticleToCataloggroupMapA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ArticleToCataloggroupMap
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TNewCatalog
	 */
	public function setArticleToCataloggroupMap($value)
	{
		$this->__ArticleToCataloggroupMapA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TNewCatalog_Bmecat_ArticleToCataloggroupMap[]
	 */
	public function getAllArticleToCataloggroupMap()
	{
		return $this->__ArticleToCataloggroupMapA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:T_NEW_CATALOG');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:T_NEW_CATALOG');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FeatureSystem != null){
			$this->__FeatureSystem->toXml($xml);
		}
		if($this->__ClassificationSystemA != null){
			foreach($this->__ClassificationSystemA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CatalogGroupSystem != null){
			$this->__CatalogGroupSystem->toXml($xml);
		}
		if($this->__Formulas != null){
			$this->__Formulas->toXml($xml);
		}
		if($this->__IppDefinitions != null){
			$this->__IppDefinitions->toXml($xml);
		}
		if($this->__ProductA != null){
			foreach($this->__ProductA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductToCataloggroupMapA != null){
			foreach($this->__ProductToCataloggroupMapA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ArticleA != null){
			foreach($this->__ArticleA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ArticleToCataloggroupMapA != null){
			foreach($this->__ArticleToCataloggroupMapA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
