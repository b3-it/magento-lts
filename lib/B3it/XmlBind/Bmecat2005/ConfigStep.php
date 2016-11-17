<?php
class B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var StepId */
	private $_StepId = null;	

	/* @var StepHeader */
	private $_StepHeaders = array();	

	/* @var StepDescrShort */
	private $_StepDescrShorts = array();	

	/* @var StepDescrLong */
	private $_StepDescrLongs = array();	

	/* @var StepOrder */
	private $_StepOrder = null;	

	/* @var StepInteractionType */
	private $_StepInteractionType = null;	

	/* @var ConfigCode */
	private $_ConfigCode = null;	

	/* @var ProductPriceDetails */
	private $_ProductPriceDetails = null;	

	/* @var ConfigFeature */
	private $_ConfigFeature = null;	

	/* @var ConfigParts */
	private $_ConfigParts = null;	

	/* @var MinOccurance */
	private $_MinOccurance = null;	

	/* @var MaxOccurance */
	private $_MaxOccurance = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_StepId
	 */
	public function getStepId()
	{
		if($this->_StepId == null)
		{
			$this->_StepId = new B3it_XmlBind_Bmecat2005_StepId();
		}
		
		return $this->_StepId;
	}
	
	/**
	 * @param $value StepId
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStepId($value)
	{
		$this->_StepId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_StepHeader[]
	 */
	public function getAllStepHeader()
	{
		return $this->_StepHeaders;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_StepHeader and add it to list
	 * @return B3it_XmlBind_Bmecat2005_StepHeader
	 */
	public function getStepHeader()
	{
		$res = new B3it_XmlBind_Bmecat2005_StepHeader();
		$this->_StepHeaders[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value StepHeader[]
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStepHeader($value)
	{
		$this->_StepHeader = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_StepDescrShort[]
	 */
	public function getAllStepDescrShort()
	{
		return $this->_StepDescrShorts;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_StepDescrShort and add it to list
	 * @return B3it_XmlBind_Bmecat2005_StepDescrShort
	 */
	public function getStepDescrShort()
	{
		$res = new B3it_XmlBind_Bmecat2005_StepDescrShort();
		$this->_StepDescrShorts[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value StepDescrShort[]
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStepDescrShort($value)
	{
		$this->_StepDescrShort = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_StepDescrLong[]
	 */
	public function getAllStepDescrLong()
	{
		return $this->_StepDescrLongs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_StepDescrLong and add it to list
	 * @return B3it_XmlBind_Bmecat2005_StepDescrLong
	 */
	public function getStepDescrLong()
	{
		$res = new B3it_XmlBind_Bmecat2005_StepDescrLong();
		$this->_StepDescrLongs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value StepDescrLong[]
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStepDescrLong($value)
	{
		$this->_StepDescrLong = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_StepOrder
	 */
	public function getStepOrder()
	{
		if($this->_StepOrder == null)
		{
			$this->_StepOrder = new B3it_XmlBind_Bmecat2005_StepOrder();
		}
		
		return $this->_StepOrder;
	}
	
	/**
	 * @param $value StepOrder
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStepOrder($value)
	{
		$this->_StepOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_StepInteractionType
	 */
	public function getStepInteractionType()
	{
		if($this->_StepInteractionType == null)
		{
			$this->_StepInteractionType = new B3it_XmlBind_Bmecat2005_StepInteractionType();
		}
		
		return $this->_StepInteractionType;
	}
	
	/**
	 * @param $value StepInteractionType
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStepInteractionType($value)
	{
		$this->_StepInteractionType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigCode
	 */
	public function getConfigCode()
	{
		if($this->_ConfigCode == null)
		{
			$this->_ConfigCode = new B3it_XmlBind_Bmecat2005_ConfigCode();
		}
		
		return $this->_ConfigCode;
	}
	
	/**
	 * @param $value ConfigCode
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigCode($value)
	{
		$this->_ConfigCode = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPriceDetails($value)
	{
		$this->_ProductPriceDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigFeature
	 */
	public function getConfigFeature()
	{
		if($this->_ConfigFeature == null)
		{
			$this->_ConfigFeature = new B3it_XmlBind_Bmecat2005_ConfigFeature();
		}
		
		return $this->_ConfigFeature;
	}
	
	/**
	 * @param $value ConfigFeature
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigFeature($value)
	{
		$this->_ConfigFeature = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigParts
	 */
	public function getConfigParts()
	{
		if($this->_ConfigParts == null)
		{
			$this->_ConfigParts = new B3it_XmlBind_Bmecat2005_ConfigParts();
		}
		
		return $this->_ConfigParts;
	}
	
	/**
	 * @param $value ConfigParts
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigParts($value)
	{
		$this->_ConfigParts = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MinOccurance
	 */
	public function getMinOccurance()
	{
		if($this->_MinOccurance == null)
		{
			$this->_MinOccurance = new B3it_XmlBind_Bmecat2005_MinOccurance();
		}
		
		return $this->_MinOccurance;
	}
	
	/**
	 * @param $value MinOccurance
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMinOccurance($value)
	{
		$this->_MinOccurance = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MaxOccurance
	 */
	public function getMaxOccurance()
	{
		if($this->_MaxOccurance == null)
		{
			$this->_MaxOccurance = new B3it_XmlBind_Bmecat2005_MaxOccurance();
		}
		
		return $this->_MaxOccurance;
	}
	
	/**
	 * @param $value MaxOccurance
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMaxOccurance($value)
	{
		$this->_MaxOccurance = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CONFIG_STEP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_StepId != null){
			$this->_StepId->toXml($xml);
		}
		if($this->_StepHeaders != null){
			foreach($this->_StepHeaders as $item){
				$item->toXml($xml);
			}
		}
		if($this->_StepDescrShorts != null){
			foreach($this->_StepDescrShorts as $item){
				$item->toXml($xml);
			}
		}
		if($this->_StepDescrLongs != null){
			foreach($this->_StepDescrLongs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_StepOrder != null){
			$this->_StepOrder->toXml($xml);
		}
		if($this->_StepInteractionType != null){
			$this->_StepInteractionType->toXml($xml);
		}
		if($this->_ConfigCode != null){
			$this->_ConfigCode->toXml($xml);
		}
		if($this->_ProductPriceDetails != null){
			$this->_ProductPriceDetails->toXml($xml);
		}
		if($this->_ConfigFeature != null){
			$this->_ConfigFeature->toXml($xml);
		}
		if($this->_ConfigParts != null){
			$this->_ConfigParts->toXml($xml);
		}
		if($this->_MinOccurance != null){
			$this->_MinOccurance->toXml($xml);
		}
		if($this->_MaxOccurance != null){
			$this->_MaxOccurance->toXml($xml);
		}


		return $xml;
	}
}