<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Contactpersonprimary
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Contactpersonprimary extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Contactperson */
	private $__Contactperson = null;

	/* @var B3it_XmlBind_Wms13_Contactorganization */
	private $__Contactorganization = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactperson
	 */
	public function getContactperson()
	{
		if($this->__Contactperson == null)
		{
			$this->__Contactperson = new B3it_XmlBind_Wms13_Contactperson();
		}
	
		return $this->__Contactperson;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactperson
	 * @return B3it_XmlBind_Wms13_Contactpersonprimary
	 */
	public function setContactperson($value)
	{
		$this->__Contactperson = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactorganization
	 */
	public function getContactorganization()
	{
		if($this->__Contactorganization == null)
		{
			$this->__Contactorganization = new B3it_XmlBind_Wms13_Contactorganization();
		}
	
		return $this->__Contactorganization;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactorganization
	 * @return B3it_XmlBind_Wms13_Contactpersonprimary
	 */
	public function setContactorganization($value)
	{
		$this->__Contactorganization = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ContactPersonPrimary');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Contactperson != null){
			$this->__Contactperson->toXml($xml);
		}
		if($this->__Contactorganization != null){
			$this->__Contactorganization->toXml($xml);
		}


		return $xml;
	}

}
