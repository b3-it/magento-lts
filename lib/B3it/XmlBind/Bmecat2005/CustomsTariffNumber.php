<?php
class B3it_XmlBind_Bmecat2005_CustomsTariffNumber extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var CustomsNumber */
	private $_CustomsNumber = null;	

	/* @var Territory */
	private $_Territorys = array();	

	/* @var AreaRefs */
	private $_AreaRefs = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_CustomsNumber
	 */
	public function getCustomsNumber()
	{
		if($this->_CustomsNumber == null)
		{
			$this->_CustomsNumber = new B3it_XmlBind_Bmecat2005_CustomsNumber();
		}
		
		return $this->_CustomsNumber;
	}
	
	/**
	 * @param $value CustomsNumber
	 * @return B3it_XmlBind_Bmecat2005_CustomsTariffNumber extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCustomsNumber($value)
	{
		$this->_CustomsNumber = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_CustomsTariffNumber extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_CustomsTariffNumber extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaRefs($value)
	{
		$this->_AreaRefs = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CUSTOMS_TARIFF_NUMBER');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_CustomsNumber != null){
			$this->_CustomsNumber->toXml($xml);
		}
		if($this->_Territorys != null){
			foreach($this->_Territorys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AreaRefs != null){
			$this->_AreaRefs->toXml($xml);
		}


		return $xml;
	}
}