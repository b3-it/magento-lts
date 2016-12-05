<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_TUpdatePrices
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Formulas */
	private $__Formulas = null;

	
	/* @var B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product */
	private $__ProductA = array();

	
	/* @var B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article */
	private $__ArticleA = array();


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices
	 */
	public function setFormulas($value)
	{
		$this->__Formulas = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product and add it to list
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product
	 */
	public function getProduct()
	{
		$res = new B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product();
		$this->__ProductA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices
	 */
	public function setProduct($value)
	{
		$this->__ProductA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Product[]
	 */
	public function getAllProduct()
	{
		return $this->__ProductA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article and add it to list
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article
	 */
	public function getArticle()
	{
		$res = new B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article();
		$this->__ArticleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TUpdatePrices
	 */
	public function setArticle($value)
	{
		$this->__ArticleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TUpdatePrices_Bmecat_Article[]
	 */
	public function getAllArticle()
	{
		return $this->__ArticleA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:T_UPDATE_PRICES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:T_UPDATE_PRICES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Formulas != null){
			$this->__Formulas->toXml($xml);
		}
		if($this->__ProductA != null){
			foreach($this->__ProductA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ArticleA != null){
			foreach($this->__ArticleA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
