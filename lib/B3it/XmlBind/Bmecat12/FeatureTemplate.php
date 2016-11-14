<?php
class B3it_XmlBind_Bmecat12_FeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var FtName */
	private $_FtName = null;	

	/* @var FtUnit */
	private $_FtUnit = null;	

	/* @var FtOrder */
	private $_FtOrder = null;	

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
	 * @return B3it_XmlBind_Bmecat12_FtName
	 */
	public function getFtName()
	{
		if($this->_FtName == null)
		{
			$this->_FtName = new B3it_XmlBind_Bmecat12_FtName();
		}
		
		return $this->_FtName;
	}
	
	/**
	 * @param $value FtName
	 * @return B3it_XmlBind_Bmecat12_FeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtName($value)
	{
		$this->_FtName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtUnit
	 */
	public function getFtUnit()
	{
		if($this->_FtUnit == null)
		{
			$this->_FtUnit = new B3it_XmlBind_Bmecat12_FtUnit();
		}
		
		return $this->_FtUnit;
	}
	
	/**
	 * @param $value FtUnit
	 * @return B3it_XmlBind_Bmecat12_FeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtUnit($value)
	{
		$this->_FtUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtOrder
	 */
	public function getFtOrder()
	{
		if($this->_FtOrder == null)
		{
			$this->_FtOrder = new B3it_XmlBind_Bmecat12_FtOrder();
		}
		
		return $this->_FtOrder;
	}
	
	/**
	 * @param $value FtOrder
	 * @return B3it_XmlBind_Bmecat12_FeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtOrder($value)
	{
		$this->_FtOrder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FEATURE_TEMPLATE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtName != null){
			$this->_FtName->toXml($xml);
		}
		if($this->_FtUnit != null){
			$this->_FtUnit->toXml($xml);
		}
		if($this->_FtOrder != null){
			$this->_FtOrder->toXml($xml);
		}


		return $xml;
	}
}