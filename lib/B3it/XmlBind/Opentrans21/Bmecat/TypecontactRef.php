<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_TypecontactRef
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_TypecontactRef extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartyIdref */
	private $__PartyIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ContactIdref */
	private $__ContactIdrefA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartyIdref
	 */
	public function getPartyIdref()
	{
		if($this->__PartyIdref == null)
		{
			$this->__PartyIdref = new B3it_XmlBind_Opentrans21_Bmecat_PartyIdref();
		}
	
		return $this->__PartyIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PartyIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypecontactRef
	 */
	public function setPartyIdref($value)
	{
		$this->__PartyIdref = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ContactIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactIdref
	 */
	public function getContactIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ContactIdref();
		$this->__ContactIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ContactIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypecontactRef
	 */
	public function setContactIdref($value)
	{
		$this->__ContactIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactIdref[]
	 */
	public function getAllContactIdref()
	{
		return $this->__ContactIdrefA;
	}







	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PartyIdref != null){
			$this->__PartyIdref->toXml($xml);
		}
		if($this->__ContactIdrefA != null){
			foreach($this->__ContactIdrefA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
