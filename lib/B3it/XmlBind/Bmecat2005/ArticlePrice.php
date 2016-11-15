<?php
class B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PriceAmount */
	private $_PriceAmount = null;	

	/* @var PriceFormula */
	private $_PriceFormula = null;	

	/* @var PriceCurrency */
	private $_PriceCurrency = null;	

	/* @var TaxDetails */
	private $_TaxDetailss = array();	

	/* @var Tax */
	private $_Tax = null;	

	/* @var PriceFactor */
	private $_PriceFactor = null;	

	/* @var LowerBound */
	private $_LowerBound = null;	

	/* @var Territory */
	private $_Territorys = array();	

	/* @var AreaRefs */
	private $_AreaRefs = null;	

	/* @var PriceBase */
	private $_PriceBase = null;	

	/* @var PriceFlag */
	private $_PriceFlags = array();	

	/* @var Leadtime */
	private $_Leadtime = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PriceAmount
	 */
	public function getPriceAmount()
	{
		if($this->_PriceAmount == null)
		{
			$this->_PriceAmount = new B3it_XmlBind_Bmecat2005_PriceAmount();
		}
		
		return $this->_PriceAmount;
	}
	
	/**
	 * @param $value PriceAmount
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceAmount($value)
	{
		$this->_PriceAmount = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceFormula
	 */
	public function getPriceFormula()
	{
		if($this->_PriceFormula == null)
		{
			$this->_PriceFormula = new B3it_XmlBind_Bmecat2005_PriceFormula();
		}
		
		return $this->_PriceFormula;
	}
	
	/**
	 * @param $value PriceFormula
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceFormula($value)
	{
		$this->_PriceFormula = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceCurrency
	 */
	public function getPriceCurrency()
	{
		if($this->_PriceCurrency == null)
		{
			$this->_PriceCurrency = new B3it_XmlBind_Bmecat2005_PriceCurrency();
		}
		
		return $this->_PriceCurrency;
	}
	
	/**
	 * @param $value PriceCurrency
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceCurrency($value)
	{
		$this->_PriceCurrency = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails[]
	 */
	public function getAllTaxDetails()
	{
		return $this->_TaxDetailss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TaxDetails and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails
	 */
	public function getTaxDetails()
	{
		$res = new B3it_XmlBind_Bmecat2005_TaxDetails();
		$this->_TaxDetailss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value TaxDetails[]
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTaxDetails($value)
	{
		$this->_TaxDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Tax
	 */
	public function getTax()
	{
		if($this->_Tax == null)
		{
			$this->_Tax = new B3it_XmlBind_Bmecat2005_Tax();
		}
		
		return $this->_Tax;
	}
	
	/**
	 * @param $value Tax
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTax($value)
	{
		$this->_Tax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceFactor
	 */
	public function getPriceFactor()
	{
		if($this->_PriceFactor == null)
		{
			$this->_PriceFactor = new B3it_XmlBind_Bmecat2005_PriceFactor();
		}
		
		return $this->_PriceFactor;
	}
	
	/**
	 * @param $value PriceFactor
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceFactor($value)
	{
		$this->_PriceFactor = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_LowerBound
	 */
	public function getLowerBound()
	{
		if($this->_LowerBound == null)
		{
			$this->_LowerBound = new B3it_XmlBind_Bmecat2005_LowerBound();
		}
		
		return $this->_LowerBound;
	}
	
	/**
	 * @param $value LowerBound
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLowerBound($value)
	{
		$this->_LowerBound = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->_Territorys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Territory and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Bmecat2005_Territory();
		$this->_Territorys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Territory[]
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTerritory($value)
	{
		$this->_Territory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AreaRefs
	 */
	public function getAreaRefs()
	{
		if($this->_AreaRefs == null)
		{
			$this->_AreaRefs = new B3it_XmlBind_Bmecat2005_AreaRefs();
		}
		
		return $this->_AreaRefs;
	}
	
	/**
	 * @param $value AreaRefs
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaRefs($value)
	{
		$this->_AreaRefs = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceBase
	 */
	public function getPriceBase()
	{
		if($this->_PriceBase == null)
		{
			$this->_PriceBase = new B3it_XmlBind_Bmecat2005_PriceBase();
		}
		
		return $this->_PriceBase;
	}
	
	/**
	 * @param $value PriceBase
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceBase($value)
	{
		$this->_PriceBase = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceFlag[]
	 */
	public function getAllPriceFlag()
	{
		return $this->_PriceFlags;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PriceFlag and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PriceFlag
	 */
	public function getPriceFlag()
	{
		$res = new B3it_XmlBind_Bmecat2005_PriceFlag();
		$this->_PriceFlags[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PriceFlag[]
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceFlag($value)
	{
		$this->_PriceFlag = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Leadtime
	 */
	public function getLeadtime()
	{
		if($this->_Leadtime == null)
		{
			$this->_Leadtime = new B3it_XmlBind_Bmecat2005_Leadtime();
		}
		
		return $this->_Leadtime;
	}
	
	/**
	 * @param $value Leadtime
	 * @return B3it_XmlBind_Bmecat2005_ArticlePrice extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLeadtime($value)
	{
		$this->_Leadtime = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_PRICE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PriceAmount != null){
			$this->_PriceAmount->toXml($xml);
		}
		if($this->_PriceFormula != null){
			$this->_PriceFormula->toXml($xml);
		}
		if($this->_PriceCurrency != null){
			$this->_PriceCurrency->toXml($xml);
		}
		if($this->_TaxDetailss != null){
			foreach($this->_TaxDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Tax != null){
			$this->_Tax->toXml($xml);
		}
		if($this->_PriceFactor != null){
			$this->_PriceFactor->toXml($xml);
		}
		if($this->_LowerBound != null){
			$this->_LowerBound->toXml($xml);
		}
		if($this->_Territorys != null){
			foreach($this->_Territorys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AreaRefs != null){
			$this->_AreaRefs->toXml($xml);
		}
		if($this->_PriceBase != null){
			$this->_PriceBase->toXml($xml);
		}
		if($this->_PriceFlags != null){
			foreach($this->_PriceFlags as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Leadtime != null){
			$this->_Leadtime->toXml($xml);
		}


		return $xml;
	}
}