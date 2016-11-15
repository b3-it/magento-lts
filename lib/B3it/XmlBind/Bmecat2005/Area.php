<?php
class B3it_XmlBind_Bmecat2005_Area extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AreaId */
	private $_AreaId = null;	

	/* @var AreaName */
	private $_AreaNames = array();	

	/* @var AreaDescr */
	private $_AreaDescrs = array();	

	/* @var Territories */
	private $_Territories = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_AreaId
	 */
	public function getAreaId()
	{
		if($this->_AreaId == null)
		{
			$this->_AreaId = new B3it_XmlBind_Bmecat2005_AreaId();
		}
		
		return $this->_AreaId;
	}
	
	/**
	 * @param $value AreaId
	 * @return B3it_XmlBind_Bmecat2005_Area extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaId($value)
	{
		$this->_AreaId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AreaName[]
	 */
	public function getAllAreaName()
	{
		return $this->_AreaNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AreaName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AreaName
	 */
	public function getAreaName()
	{
		$res = new B3it_XmlBind_Bmecat2005_AreaName();
		$this->_AreaNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AreaName[]
	 * @return B3it_XmlBind_Bmecat2005_Area extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaName($value)
	{
		$this->_AreaName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AreaDescr[]
	 */
	public function getAllAreaDescr()
	{
		return $this->_AreaDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AreaDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AreaDescr
	 */
	public function getAreaDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_AreaDescr();
		$this->_AreaDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AreaDescr[]
	 * @return B3it_XmlBind_Bmecat2005_Area extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaDescr($value)
	{
		$this->_AreaDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Territories
	 */
	public function getTerritories()
	{
		if($this->_Territories == null)
		{
			$this->_Territories = new B3it_XmlBind_Bmecat2005_Territories();
		}
		
		return $this->_Territories;
	}
	
	/**
	 * @param $value Territories
	 * @return B3it_XmlBind_Bmecat2005_Area extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTerritories($value)
	{
		$this->_Territories = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AREA');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AreaId != null){
			$this->_AreaId->toXml($xml);
		}
		if($this->_AreaNames != null){
			foreach($this->_AreaNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AreaDescrs != null){
			foreach($this->_AreaDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Territories != null){
			$this->_Territories->toXml($xml);
		}


		return $xml;
	}
}