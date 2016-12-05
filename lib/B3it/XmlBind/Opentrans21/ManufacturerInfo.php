<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ManufacturerInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ManufacturerInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref */
	private $__ManufacturerIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid */
	private $__ManufacturerPid = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr */
	private $__ManufacturerTypeDescrA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref
	 */
	public function getManufacturerIdref()
	{
		if($this->__ManufacturerIdref == null)
		{
			$this->__ManufacturerIdref = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref();
		}
	
		return $this->__ManufacturerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerIdref
	 * @return B3it_XmlBind_Opentrans21_ManufacturerInfo
	 */
	public function setManufacturerIdref($value)
	{
		$this->__ManufacturerIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid
	 */
	public function getManufacturerPid()
	{
		if($this->__ManufacturerPid == null)
		{
			$this->__ManufacturerPid = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid();
		}
	
		return $this->__ManufacturerPid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerPid
	 * @return B3it_XmlBind_Opentrans21_ManufacturerInfo
	 */
	public function setManufacturerPid($value)
	{
		$this->__ManufacturerPid = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr
	 */
	public function getManufacturerTypeDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr();
		$this->__ManufacturerTypeDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr
	 * @return B3it_XmlBind_Opentrans21_ManufacturerInfo
	 */
	public function setManufacturerTypeDescr($value)
	{
		$this->__ManufacturerTypeDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ManufacturerTypeDescr[]
	 */
	public function getAllManufacturerTypeDescr()
	{
		return $this->__ManufacturerTypeDescrA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('MANUFACTURER_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ManufacturerIdref != null){
			$this->__ManufacturerIdref->toXml($xml);
		}
		if($this->__ManufacturerPid != null){
			$this->__ManufacturerPid->toXml($xml);
		}
		if($this->__ManufacturerTypeDescrA != null){
			foreach($this->__ManufacturerTypeDescrA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
