<?php
class B3it_XmlBind_Bmecat2005_TUpdatePrices extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Formulas */
	private $_Formulas = null;	

	/* @var TUpdatePrices_Product */
	private $_Products = array();	

	/* @var TUpdatePrices_Article */
	private $_Articles = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulas($value)
	{
		$this->_Formulas = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Product[]
	 */
	public function getAllProduct()
	{
		return $this->_Products;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TUpdatePrices_Product and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Product
	 */
	public function getProduct()
	{
		$res = new B3it_XmlBind_Bmecat2005_TUpdatePrices_Product();
		$this->_Products[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Product[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProduct($value)
	{
		$this->_Product = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Article[]
	 */
	public function getAllArticle()
	{
		return $this->_Articles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TUpdatePrices_Article and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Article
	 */
	public function getArticle()
	{
		$res = new B3it_XmlBind_Bmecat2005_TUpdatePrices_Article();
		$this->_Articles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Article[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setArticle($value)
	{
		$this->_Article = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('T_UPDATE_PRICES');
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
		if($this->_Articles != null){
			foreach($this->_Articles as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}