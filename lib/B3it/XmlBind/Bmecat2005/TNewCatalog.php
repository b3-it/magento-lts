<?php
class B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FeatureSystem */
	private $_FeatureSystem = null;	

	/* @var ClassificationSystem */
	private $_ClassificationSystems = array();	

	/* @var CatalogGroupSystem */
	private $_CatalogGroupSystem = null;	

	/* @var Formulas */
	private $_Formulas = null;	

	/* @var IppDefinitions */
	private $_IppDefinitions = null;	

	/* @var TNewCatalog_Product */
	private $_Products = array();	

	/* @var TNewCatalog_ProductToCataloggroupMap */
	private $_ProductToCataloggroupMaps = array();	

	/* @var TNewCatalog_Article */
	private $_Articles = array();	

	/* @var TNewCatalog_ArticleToCataloggroupMap */
	private $_ArticleToCataloggroupMaps = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_FeatureSystem
	 */
	public function getFeatureSystem()
	{
		if($this->_FeatureSystem == null)
		{
			$this->_FeatureSystem = new B3it_XmlBind_Bmecat2005_FeatureSystem();
		}
		
		return $this->_FeatureSystem;
	}
	
	/**
	 * @param $value FeatureSystem
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFeatureSystem($value)
	{
		$this->_FeatureSystem = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem[]
	 */
	public function getAllClassificationSystem()
	{
		return $this->_ClassificationSystems;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationSystem and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem
	 */
	public function getClassificationSystem()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationSystem();
		$this->_ClassificationSystems[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationSystem[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystem($value)
	{
		$this->_ClassificationSystem = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogGroupSystem
	 */
	public function getCatalogGroupSystem()
	{
		if($this->_CatalogGroupSystem == null)
		{
			$this->_CatalogGroupSystem = new B3it_XmlBind_Bmecat2005_CatalogGroupSystem();
		}
		
		return $this->_CatalogGroupSystem;
	}
	
	/**
	 * @param $value CatalogGroupSystem
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogGroupSystem($value)
	{
		$this->_CatalogGroupSystem = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Formulas
	 */
	public function getFormulas()
	{
		if($this->_Formulas == null)
		{
			$this->_Formulas = new B3it_XmlBind_Bmecat2005_Formulas();
		}
		
		return $this->_Formulas;
	}
	
	/**
	 * @param $value Formulas
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulas($value)
	{
		$this->_Formulas = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppDefinitions
	 */
	public function getIppDefinitions()
	{
		if($this->_IppDefinitions == null)
		{
			$this->_IppDefinitions = new B3it_XmlBind_Bmecat2005_IppDefinitions();
		}
		
		return $this->_IppDefinitions;
	}
	
	/**
	 * @param $value IppDefinitions
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppDefinitions($value)
	{
		$this->_IppDefinitions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Product[]
	 */
	public function getAllProduct()
	{
		return $this->_Products;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TNewCatalog_Product and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Product
	 */
	public function getProduct()
	{
		$res = new B3it_XmlBind_Bmecat2005_TNewCatalog_Product();
		$this->_Products[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Product[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProduct($value)
	{
		$this->_Product = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap[]
	 */
	public function getAllProductToCataloggroupMap()
	{
		return $this->_ProductToCataloggroupMaps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap
	 */
	public function getProductToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Bmecat2005_TNewCatalog_ProductToCataloggroupMap();
		$this->_ProductToCataloggroupMaps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductToCataloggroupMap[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductToCataloggroupMap($value)
	{
		$this->_ProductToCataloggroupMap = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article[]
	 */
	public function getAllArticle()
	{
		return $this->_Articles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TNewCatalog_Article and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_Article
	 */
	public function getArticle()
	{
		$res = new B3it_XmlBind_Bmecat2005_TNewCatalog_Article();
		$this->_Articles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Article[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticle($value)
	{
		$this->_Article = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ArticleToCataloggroupMap[]
	 */
	public function getAllArticleToCataloggroupMap()
	{
		return $this->_ArticleToCataloggroupMaps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TNewCatalog_ArticleToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog_ArticleToCataloggroupMap
	 */
	public function getArticleToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Bmecat2005_TNewCatalog_ArticleToCataloggroupMap();
		$this->_ArticleToCataloggroupMaps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleToCataloggroupMap[]
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleToCataloggroupMap($value)
	{
		$this->_ArticleToCataloggroupMap = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('T_NEW_CATALOG');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FeatureSystem != null){
			$this->_FeatureSystem->toXml($xml);
		}
		if($this->_ClassificationSystems != null){
			foreach($this->_ClassificationSystems as $item){
				$item->toXml($xml);
			}
		}
		if($this->_CatalogGroupSystem != null){
			$this->_CatalogGroupSystem->toXml($xml);
		}
		if($this->_Formulas != null){
			$this->_Formulas->toXml($xml);
		}
		if($this->_IppDefinitions != null){
			$this->_IppDefinitions->toXml($xml);
		}
		if($this->_Products != null){
			foreach($this->_Products as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ProductToCataloggroupMaps != null){
			foreach($this->_ProductToCataloggroupMaps as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Articles != null){
			foreach($this->_Articles as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ArticleToCataloggroupMaps != null){
			foreach($this->_ArticleToCataloggroupMaps as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}