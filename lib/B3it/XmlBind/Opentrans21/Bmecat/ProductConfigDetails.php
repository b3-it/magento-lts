<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ProductConfigDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigStep */
	private $__ConfigStepA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs */
	private $__PredefinedConfigs = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigRules */
	private $__ConfigRules = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigFormulas */
	private $__ConfigFormulas = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ConfigStep and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 */
	public function getConfigStep()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ConfigStep();
		$this->__ConfigStepA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigStep
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails
	 */
	public function setConfigStep($value)
	{
		$this->__ConfigStepA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigStep[]
	 */
	public function getAllConfigStep()
	{
		return $this->__ConfigStepA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs
	 */
	public function getPredefinedConfigs()
	{
		if($this->__PredefinedConfigs == null)
		{
			$this->__PredefinedConfigs = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs();
		}
	
		return $this->__PredefinedConfigs;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails
	 */
	public function setPredefinedConfigs($value)
	{
		$this->__PredefinedConfigs = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigRules
	 */
	public function getConfigRules()
	{
		if($this->__ConfigRules == null)
		{
			$this->__ConfigRules = new B3it_XmlBind_Opentrans21_Bmecat_ConfigRules();
		}
	
		return $this->__ConfigRules;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigRules
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails
	 */
	public function setConfigRules($value)
	{
		$this->__ConfigRules = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFormulas
	 */
	public function getConfigFormulas()
	{
		if($this->__ConfigFormulas == null)
		{
			$this->__ConfigFormulas = new B3it_XmlBind_Opentrans21_Bmecat_ConfigFormulas();
		}
	
		return $this->__ConfigFormulas;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigFormulas
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductConfigDetails
	 */
	public function setConfigFormulas($value)
	{
		$this->__ConfigFormulas = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_CONFIG_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_CONFIG_DETAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ConfigStepA != null){
			foreach($this->__ConfigStepA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PredefinedConfigs != null){
			$this->__PredefinedConfigs->toXml($xml);
		}
		if($this->__ConfigRules != null){
			$this->__ConfigRules->toXml($xml);
		}
		if($this->__ConfigFormulas != null){
			$this->__ConfigFormulas->toXml($xml);
		}


		return $xml;
	}

}
