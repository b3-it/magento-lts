<?php
class B3it_XmlBind_Bmecat12_TNewCatalog extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var FeatureSystem */
	private $_FeatureSystems = array();	

	/* @var ClassificationSystem */
	private $_ClassificationSystems = array();	

	/* @var CatalogGroupSystem */
	private $_CatalogGroupSystem = null;	

	/* @var Article */
	private $_Articles = array();	

	/* @var ArticleToCataloggroupMap */
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
	 * @return B3it_XmlBind_Bmecat12_FeatureSystem[]
	 */
	public function getAllFeatureSystem()
	{
		return $this->_FeatureSystems;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_FeatureSystem and add it to list
	 * @return B3it_XmlBind_Bmecat12_FeatureSystem
	 */
	public function getFeatureSystem()
	{
		$res = new B3it_XmlBind_Bmecat12_FeatureSystem();
		$this->_FeatureSystems[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FeatureSystem[]
	 * @return B3it_XmlBind_Bmecat12_TNewCatalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFeatureSystem($value)
	{
		$this->_FeatureSystem = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem[]
	 */
	public function getAllClassificationSystem()
	{
		return $this->_ClassificationSystems;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ClassificationSystem and add it to list
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem
	 */
	public function getClassificationSystem()
	{
		$res = new B3it_XmlBind_Bmecat12_ClassificationSystem();
		$this->_ClassificationSystems[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationSystem[]
	 * @return B3it_XmlBind_Bmecat12_TNewCatalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystem($value)
	{
		$this->_ClassificationSystem = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogGroupSystem
	 */
	public function getCatalogGroupSystem()
	{
		if($this->_CatalogGroupSystem == null)
		{
			$this->_CatalogGroupSystem = new B3it_XmlBind_Bmecat12_CatalogGroupSystem();
		}
		
		return $this->_CatalogGroupSystem;
	}
	
	/**
	 * @param $value CatalogGroupSystem
	 * @return B3it_XmlBind_Bmecat12_TNewCatalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogGroupSystem($value)
	{
		$this->_CatalogGroupSystem = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Article[]
	 */
	public function getAllArticle()
	{
		return $this->_Articles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Article and add it to list
	 * @return B3it_XmlBind_Bmecat12_Article
	 */
	public function getArticle()
	{
		$res = new B3it_XmlBind_Bmecat12_Article();
		$this->_Articles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Article[]
	 * @return B3it_XmlBind_Bmecat12_TNewCatalog extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setArticle($value)
	{
		$this->_Article = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ArticleToCataloggroupMap[]
	 */
	public function getAllArticleToCataloggroupMap()
	{
		return $this->_ArticleToCataloggroupMaps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ArticleToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Bmecat12_ArticleToCataloggroupMap
	 */
	public function getArticleToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Bmecat12_ArticleToCataloggroupMap();
		$this->_ArticleToCataloggroupMaps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleToCataloggroupMap[]
	 * @return B3it_XmlBind_Bmecat12_TNewCatalog extends B3it_XmlBind_Bmecat12_XmlBind
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

		if($this->_FeatureSystems != null){
			foreach($this->_FeatureSystems as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationSystems != null){
			foreach($this->_ClassificationSystems as $item){
				$item->toXml($xml);
			}
		}
		if($this->_CatalogGroupSystem != null){
			$this->_CatalogGroupSystem->toXml($xml);
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