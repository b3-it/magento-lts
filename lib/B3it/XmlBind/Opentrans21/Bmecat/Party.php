<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Party
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Party extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartyId */
	private $__PartyIdA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartyRole */
	private $__PartyRoleA = array();

	/* @var B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address */
	private $__Address = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PartyId and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartyId
	 */
	public function getPartyId()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PartyId();
		$this->__PartyIdA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PartyId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Party
	 */
	public function setPartyId($value)
	{
		$this->__PartyIdA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartyId[]
	 */
	public function getAllPartyId()
	{
		return $this->__PartyIdA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PartyRole and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartyRole
	 */
	public function getPartyRole()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PartyRole();
		$this->__PartyRoleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PartyRole
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Party
	 */
	public function setPartyRole($value)
	{
		$this->__PartyRoleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartyRole[]
	 */
	public function getAllPartyRole()
	{
		return $this->__PartyRoleA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address
	 */
	public function getAddress()
	{
		if($this->__Address == null)
		{
			$this->__Address = new B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address();
		}
	
		return $this->__Address;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Supplier_Bmecat_Address
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Party
	 */
	public function setAddress($value)
	{
		$this->__Address = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Party
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARTY');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARTY');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PartyIdA != null){
			foreach($this->__PartyIdA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PartyRoleA != null){
			foreach($this->__PartyRoleA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Address != null){
			$this->__Address->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
