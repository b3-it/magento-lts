<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ParameterBasics
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterName */
	private $__ParameterNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterDescr */
	private $__ParameterDescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterUnit */
	private $__ParameterUnitA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ParameterName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterName
	 */
	public function getParameterName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ParameterName();
		$this->__ParameterNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics
	 */
	public function setParameterName($value)
	{
		$this->__ParameterNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterName[]
	 */
	public function getAllParameterName()
	{
		return $this->__ParameterNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ParameterDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDescr
	 */
	public function getParameterDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ParameterDescr();
		$this->__ParameterDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics
	 */
	public function setParameterDescr($value)
	{
		$this->__ParameterDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDescr[]
	 */
	public function getAllParameterDescr()
	{
		return $this->__ParameterDescrA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ParameterUnit and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterUnit
	 */
	public function getParameterUnit()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ParameterUnit();
		$this->__ParameterUnitA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterUnit
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterBasics
	 */
	public function setParameterUnit($value)
	{
		$this->__ParameterUnitA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterUnit[]
	 */
	public function getAllParameterUnit()
	{
		return $this->__ParameterUnitA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER_BASICS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER_BASICS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ParameterNameA != null){
			foreach($this->__ParameterNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ParameterDescrA != null){
			foreach($this->__ParameterDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ParameterUnitA != null){
			foreach($this->__ParameterUnitA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
