<?php
class B3it_XmlBind_Bmecat2005_TypecontactRef extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PartyIdref */
	private $_PartyIdref = null;	

	/* @var ContactIdref */
	private $_ContactIdrefs = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_PartyIdref
	 */
	public function getPartyIdref()
	{
		if($this->_PartyIdref == null)
		{
			$this->_PartyIdref = new B3it_XmlBind_Bmecat2005_PartyIdref();
		}
		
		return $this->_PartyIdref;
	}
	
	/**
	 * @param $value PartyIdref
	 * @return B3it_XmlBind_Bmecat2005_TypecontactRef extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPartyIdref($value)
	{
		$this->_PartyIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ContactIdref[]
	 */
	public function getAllContactIdref()
	{
		return $this->_ContactIdrefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ContactIdref and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ContactIdref
	 */
	public function getContactIdref()
	{
		$res = new B3it_XmlBind_Bmecat2005_ContactIdref();
		$this->_ContactIdrefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ContactIdref[]
	 * @return B3it_XmlBind_Bmecat2005_TypecontactRef extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContactIdref($value)
	{
		$this->_ContactIdref = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_PartyIdref != null){
			$this->_PartyIdref->toXml($xml);
		}
		if($this->_ContactIdrefs != null){
			foreach($this->_ContactIdrefs as $item){
				$item->toXml($xml);
			}
		}

		return $xml;
	}
}