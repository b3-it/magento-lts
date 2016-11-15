<?php
class B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PredefinedConfigCode */
	private $_PredefinedConfigCode = null;	

	/* @var PredefinedConfigName */
	private $_PredefinedConfigNames = array();	

	/* @var PredefinedConfigDescr */
	private $_PredefinedConfigDescrs = array();	

	/* @var PredefinedConfigOrder */
	private $_PredefinedConfigOrder = null;	

	/* @var ProductPriceDetails */
	private $_ProductPriceDetails = null;	

	/* @var SupplierPid */
	private $_SupplierPid = null;	

	/* @var InternationalPid */
	private $_InternationalPids = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigCode
	 */
	public function getPredefinedConfigCode()
	{
		if($this->_PredefinedConfigCode == null)
		{
			$this->_PredefinedConfigCode = new B3it_XmlBind_Bmecat2005_PredefinedConfigCode();
		}
		
		return $this->_PredefinedConfigCode;
	}
	
	/**
	 * @param $value PredefinedConfigCode
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfigCode($value)
	{
		$this->_PredefinedConfigCode = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigName[]
	 */
	public function getAllPredefinedConfigName()
	{
		return $this->_PredefinedConfigNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PredefinedConfigName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigName
	 */
	public function getPredefinedConfigName()
	{
		$res = new B3it_XmlBind_Bmecat2005_PredefinedConfigName();
		$this->_PredefinedConfigNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PredefinedConfigName[]
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfigName($value)
	{
		$this->_PredefinedConfigName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigDescr[]
	 */
	public function getAllPredefinedConfigDescr()
	{
		return $this->_PredefinedConfigDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PredefinedConfigDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigDescr
	 */
	public function getPredefinedConfigDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_PredefinedConfigDescr();
		$this->_PredefinedConfigDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PredefinedConfigDescr[]
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfigDescr($value)
	{
		$this->_PredefinedConfigDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigOrder
	 */
	public function getPredefinedConfigOrder()
	{
		if($this->_PredefinedConfigOrder == null)
		{
			$this->_PredefinedConfigOrder = new B3it_XmlBind_Bmecat2005_PredefinedConfigOrder();
		}
		
		return $this->_PredefinedConfigOrder;
	}
	
	/**
	 * @param $value PredefinedConfigOrder
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfigOrder($value)
	{
		$this->_PredefinedConfigOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		if($this->_ProductPriceDetails == null)
		{
			$this->_ProductPriceDetails = new B3it_XmlBind_Bmecat2005_ProductPriceDetails();
		}
		
		return $this->_ProductPriceDetails;
	}
	
	/**
	 * @param $value ProductPriceDetails
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPriceDetails($value)
	{
		$this->_ProductPriceDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierPid
	 */
	public function getSupplierPid()
	{
		if($this->_SupplierPid == null)
		{
			$this->_SupplierPid = new B3it_XmlBind_Bmecat2005_SupplierPid();
		}
		
		return $this->_SupplierPid;
	}
	
	/**
	 * @param $value SupplierPid
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierPid($value)
	{
		$this->_SupplierPid = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_InternationalPid[]
	 */
	public function getAllInternationalPid()
	{
		return $this->_InternationalPids;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_InternationalPid and add it to list
	 * @return B3it_XmlBind_Bmecat2005_InternationalPid
	 */
	public function getInternationalPid()
	{
		$res = new B3it_XmlBind_Bmecat2005_InternationalPid();
		$this->_InternationalPids[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value InternationalPid[]
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setInternationalPid($value)
	{
		$this->_InternationalPid = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PREDEFINED_CONFIG');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PredefinedConfigCode != null){
			$this->_PredefinedConfigCode->toXml($xml);
		}
		if($this->_PredefinedConfigNames != null){
			foreach($this->_PredefinedConfigNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PredefinedConfigDescrs != null){
			foreach($this->_PredefinedConfigDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PredefinedConfigOrder != null){
			$this->_PredefinedConfigOrder->toXml($xml);
		}
		if($this->_ProductPriceDetails != null){
			$this->_ProductPriceDetails->toXml($xml);
		}
		if($this->_SupplierPid != null){
			$this->_SupplierPid->toXml($xml);
		}
		if($this->_InternationalPids != null){
			foreach($this->_InternationalPids as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}