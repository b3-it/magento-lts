<?php
class B3it_XmlBind_Bmecat2005_TUpdateProducts extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Formulas */
	private $_Formulas = null;	

	/* @var TUpdateProducts_Product */
	private $_Products = array();	

	/* @var TUpdateProducts_ProductToCataloggroupMap */
	private $_ProductToCataloggroupMaps = array();	

	/* @var TUpdateProducts_Article */
	private $_Articles = array();	

	/* @var TUpdateProducts_ArticleToCataloggroupMap */
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
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulas($value)
	{
		$this->_Formulas = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product[]
	 */
	public function getAllProduct()
	{
		return $this->_Products;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TUpdateProducts_Product and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Product
	 */
	public function getProduct()
	{
		$res = new B3it_XmlBind_Bmecat2005_TUpdateProducts_Product();
		$this->_Products[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Product[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProduct($value)
	{
		$this->_Product = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ProductToCataloggroupMap[]
	 */
	public function getAllProductToCataloggroupMap()
	{
		return $this->_ProductToCataloggroupMaps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TUpdateProducts_ProductToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ProductToCataloggroupMap
	 */
	public function getProductToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Bmecat2005_TUpdateProducts_ProductToCataloggroupMap();
		$this->_ProductToCataloggroupMaps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductToCataloggroupMap[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductToCataloggroupMap($value)
	{
		$this->_ProductToCataloggroupMap = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Article[]
	 */
	public function getAllArticle()
	{
		return $this->_Articles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TUpdateProducts_Article and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_Article
	 */
	public function getArticle()
	{
		$res = new B3it_XmlBind_Bmecat2005_TUpdateProducts_Article();
		$this->_Articles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Article[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticle($value)
	{
		$this->_Article = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap[]
	 */
	public function getAllArticleToCataloggroupMap()
	{
		return $this->_ArticleToCataloggroupMaps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap
	 */
	public function getArticleToCataloggroupMap()
	{
		$res = new B3it_XmlBind_Bmecat2005_TUpdateProducts_ArticleToCataloggroupMap();
		$this->_ArticleToCataloggroupMaps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticleToCataloggroupMap[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticleToCataloggroupMap($value)
	{
		$this->_ArticleToCataloggroupMap = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('T_UPDATE_PRODUCTS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Formulas != null){
			$this->_Formulas->toXml($xml);
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