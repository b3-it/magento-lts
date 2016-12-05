<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_PredefinedConfigs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig */
	private $__PredefinedConfigA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCoverage */
	private $__PredefinedConfigCoverage = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 */
	public function getPredefinedConfig()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig();
		$this->__PredefinedConfigA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs
	 */
	public function setPredefinedConfig($value)
	{
		$this->__PredefinedConfigA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfig[]
	 */
	public function getAllPredefinedConfig()
	{
		return $this->__PredefinedConfigA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCoverage
	 */
	public function getPredefinedConfigCoverage()
	{
		if($this->__PredefinedConfigCoverage == null)
		{
			$this->__PredefinedConfigCoverage = new B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCoverage();
		}
	
		return $this->__PredefinedConfigCoverage;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigCoverage
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PredefinedConfigs
	 */
	public function setPredefinedConfigCoverage($value)
	{
		$this->__PredefinedConfigCoverage = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PREDEFINED_CONFIGS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PREDEFINED_CONFIGS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PredefinedConfigA != null){
			foreach($this->__PredefinedConfigA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PredefinedConfigCoverage != null){
			$this->__PredefinedConfigCoverage->toXml($xml);
		}


		return $xml;
	}

}
