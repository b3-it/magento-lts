<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigStep
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigStep extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_StepId */
	private $__StepId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_StepHeader */
	private $__StepHeaderA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_StepDescrShort */
	private $__StepDescrShortA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_StepDescrLong */
	private $__StepDescrLongA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_StepOrder */
	private $__StepOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_StepInteractionType */
	private $__StepInteractionType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigCode */
	private $__ConfigCode = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails */
	private $__ProductPriceDetails = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature */
	private $__ConfigFeature = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigParts */
	private $__ConfigParts = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MinOccurance */
	private $__MinOccurance = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MaxOccurance */
	private $__MaxOccurance = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepId
	 */
	public function getStepId()
	{
		if($this->__StepId == null)
		{
			$this->__StepId = new B3it_XmlBind_Opentrans21_Bmecat_StepId();
		}
	
		return $this->__StepId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StepId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setStepId($value)
	{
		$this->__StepId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_StepHeader and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepHeader
	 */
	public function getStepHeader()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_StepHeader();
		$this->__StepHeaderA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StepHeader
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setStepHeader($value)
	{
		$this->__StepHeaderA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepHeader[]
	 */
	public function getAllStepHeader()
	{
		return $this->__StepHeaderA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_StepDescrShort and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepDescrShort
	 */
	public function getStepDescrShort()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_StepDescrShort();
		$this->__StepDescrShortA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StepDescrShort
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setStepDescrShort($value)
	{
		$this->__StepDescrShortA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepDescrShort[]
	 */
	public function getAllStepDescrShort()
	{
		return $this->__StepDescrShortA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_StepDescrLong and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepDescrLong
	 */
	public function getStepDescrLong()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_StepDescrLong();
		$this->__StepDescrLongA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StepDescrLong
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setStepDescrLong($value)
	{
		$this->__StepDescrLongA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepDescrLong[]
	 */
	public function getAllStepDescrLong()
	{
		return $this->__StepDescrLongA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepOrder
	 */
	public function getStepOrder()
	{
		if($this->__StepOrder == null)
		{
			$this->__StepOrder = new B3it_XmlBind_Opentrans21_Bmecat_StepOrder();
		}
	
		return $this->__StepOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StepOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setStepOrder($value)
	{
		$this->__StepOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StepInteractionType
	 */
	public function getStepInteractionType()
	{
		if($this->__StepInteractionType == null)
		{
			$this->__StepInteractionType = new B3it_XmlBind_Opentrans21_Bmecat_StepInteractionType();
		}
	
		return $this->__StepInteractionType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StepInteractionType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setStepInteractionType($value)
	{
		$this->__StepInteractionType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigCode
	 */
	public function getConfigCode()
	{
		if($this->__ConfigCode == null)
		{
			$this->__ConfigCode = new B3it_XmlBind_Opentrans21_Bmecat_ConfigCode();
		}
	
		return $this->__ConfigCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigCode
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setConfigCode($value)
	{
		$this->__ConfigCode = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		if($this->__ProductPriceDetails == null)
		{
			$this->__ProductPriceDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails();
		}
	
		return $this->__ProductPriceDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setProductPriceDetails($value)
	{
		$this->__ProductPriceDetails = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature
	 */
	public function getConfigFeature()
	{
		if($this->__ConfigFeature == null)
		{
			$this->__ConfigFeature = new B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature();
		}
	
		return $this->__ConfigFeature;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setConfigFeature($value)
	{
		$this->__ConfigFeature = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigParts
	 */
	public function getConfigParts()
	{
		if($this->__ConfigParts == null)
		{
			$this->__ConfigParts = new B3it_XmlBind_Opentrans21_Bmecat_ConfigParts();
		}
	
		return $this->__ConfigParts;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigParts
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setConfigParts($value)
	{
		$this->__ConfigParts = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MinOccurance
	 */
	public function getMinOccurance()
	{
		if($this->__MinOccurance == null)
		{
			$this->__MinOccurance = new B3it_XmlBind_Opentrans21_Bmecat_MinOccurance();
		}
	
		return $this->__MinOccurance;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MinOccurance
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setMinOccurance($value)
	{
		$this->__MinOccurance = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MaxOccurance
	 */
	public function getMaxOccurance()
	{
		if($this->__MaxOccurance == null)
		{
			$this->__MaxOccurance = new B3it_XmlBind_Opentrans21_Bmecat_MaxOccurance();
		}
	
		return $this->__MaxOccurance;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MaxOccurance
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function setMaxOccurance($value)
	{
		$this->__MaxOccurance = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_STEP');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_STEP');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__StepId != null){
			$this->__StepId->toXml($xml);
		}
		if($this->__StepHeaderA != null){
			foreach($this->__StepHeaderA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StepDescrShortA != null){
			foreach($this->__StepDescrShortA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StepDescrLongA != null){
			foreach($this->__StepDescrLongA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StepOrder != null){
			$this->__StepOrder->toXml($xml);
		}
		if($this->__StepInteractionType != null){
			$this->__StepInteractionType->toXml($xml);
		}
		if($this->__ConfigCode != null){
			$this->__ConfigCode->toXml($xml);
		}
		if($this->__ProductPriceDetails != null){
			$this->__ProductPriceDetails->toXml($xml);
		}
		if($this->__ConfigFeature != null){
			$this->__ConfigFeature->toXml($xml);
		}
		if($this->__ConfigParts != null){
			$this->__ConfigParts->toXml($xml);
		}
		if($this->__MinOccurance != null){
			$this->__MinOccurance->toXml($xml);
		}
		if($this->__MaxOccurance != null){
			$this->__MaxOccurance->toXml($xml);
		}


		return $xml;
	}

}
