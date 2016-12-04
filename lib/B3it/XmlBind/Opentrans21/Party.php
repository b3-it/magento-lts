<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Party
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Party extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartyId */
	private $__PartyIdA = array();

	
	/* @var B3it_XmlBind_Opentrans21_PartyRole */
	private $__PartyRoleA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Address */
	private $__AddressA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Account */
	private $__AccountA = array();

	/* @var B3it_XmlBind_Opentrans21_MimeInfo */
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
	 * @return B3it_XmlBind_Opentrans21_Party
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
	 * Create new B3it_XmlBind_Opentrans21_PartyRole and add it to list
	 * @return B3it_XmlBind_Opentrans21_PartyRole
	 */
	public function getPartyRole()
	{
		$res = new B3it_XmlBind_Opentrans21_PartyRole();
		$this->__PartyRoleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PartyRole
	 * @return B3it_XmlBind_Opentrans21_Party
	 */
	public function setPartyRole($value)
	{
		$this->__PartyRoleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PartyRole[]
	 */
	public function getAllPartyRole()
	{
		return $this->__PartyRoleA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Address and add it to list
	 * @return B3it_XmlBind_Opentrans21_Address
	 */
	public function getAddress()
	{
		$res = new B3it_XmlBind_Opentrans21_Address();
		$this->__AddressA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Address
	 * @return B3it_XmlBind_Opentrans21_Party
	 */
	public function setAddress($value)
	{
		$this->__AddressA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Address[]
	 */
	public function getAllAddress()
	{
		return $this->__AddressA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Account and add it to list
	 * @return B3it_XmlBind_Opentrans21_Account
	 */
	public function getAccount()
	{
		$res = new B3it_XmlBind_Opentrans21_Account();
		$this->__AccountA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Account
	 * @return B3it_XmlBind_Opentrans21_Party
	 */
	public function setAccount($value)
	{
		$this->__AccountA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Account[]
	 */
	public function getAllAccount()
	{
		return $this->__AccountA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Party
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PARTY');
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
		if($this->__AddressA != null){
			foreach($this->__AddressA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AccountA != null){
			foreach($this->__AccountA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
