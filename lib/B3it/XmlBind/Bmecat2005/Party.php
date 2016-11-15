<?php
class B3it_XmlBind_Bmecat2005_Party extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PartyId */
	private $_PartyIds = array();	

	/* @var PartyRole */
	private $_PartyRoles = array();	

	/* @var Address */
	private $_Address = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PartyId[]
	 */
	public function getAllPartyId()
	{
		return $this->_PartyIds;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PartyId and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PartyId
	 */
	public function getPartyId()
	{
		$res = new B3it_XmlBind_Bmecat2005_PartyId();
		$this->_PartyIds[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PartyId[]
	 * @return B3it_XmlBind_Bmecat2005_Party extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPartyId($value)
	{
		$this->_PartyId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PartyRole[]
	 */
	public function getAllPartyRole()
	{
		return $this->_PartyRoles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PartyRole and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PartyRole
	 */
	public function getPartyRole()
	{
		$res = new B3it_XmlBind_Bmecat2005_PartyRole();
		$this->_PartyRoles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PartyRole[]
	 * @return B3it_XmlBind_Bmecat2005_Party extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPartyRole($value)
	{
		$this->_PartyRole = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Address
	 */
	public function getAddress()
	{
		if($this->_Address == null)
		{
			$this->_Address = new B3it_XmlBind_Bmecat2005_Address();
		}
		
		return $this->_Address;
	}
	
	/**
	 * @param $value Address
	 * @return B3it_XmlBind_Bmecat2005_Party extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAddress($value)
	{
		$this->_Address = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_Party extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARTY');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PartyIds != null){
			foreach($this->_PartyIds as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PartyRoles != null){
			foreach($this->_PartyRoles as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Address != null){
			$this->_Address->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}


		return $xml;
	}
}