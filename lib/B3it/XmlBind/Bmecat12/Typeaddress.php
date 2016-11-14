<?php
class B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Name */
	private $_Name = null;	

	/* @var Name2 */
	private $_Name2 = null;	

	/* @var Name3 */
	private $_Name3 = null;	

	/* @var Contact */
	private $_Contact = null;	

	/* @var Street */
	private $_Street = null;	

	/* @var Zip */
	private $_Zip = null;	

	/* @var Boxno */
	private $_Boxno = null;	

	/* @var Zipbox */
	private $_Zipbox = null;	

	/* @var City */
	private $_City = null;	

	/* @var State */
	private $_State = null;	

	/* @var Country */
	private $_Country = null;	

	/* @var Phone */
	private $_Phone = null;	

	/* @var Fax */
	private $_Fax = null;	

	/* @var Email */
	private $_Email = null;	

	/* @var PublicKey */
	private $_PublicKeys = array();	

	/* @var Url */
	private $_Url = null;	

	/* @var AddressRemarks */
	private $_AddressRemarks = null;	

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
	 * @return B3it_XmlBind_Bmecat12_Name
	 */
	public function getName()
	{
		if($this->_Name == null)
		{
			$this->_Name = new B3it_XmlBind_Bmecat12_Name();
		}
		
		return $this->_Name;
	}
	
	/**
	 * @param $value Name
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setName($value)
	{
		$this->_Name = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Name2
	 */
	public function getName2()
	{
		if($this->_Name2 == null)
		{
			$this->_Name2 = new B3it_XmlBind_Bmecat12_Name2();
		}
		
		return $this->_Name2;
	}
	
	/**
	 * @param $value Name2
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setName2($value)
	{
		$this->_Name2 = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Name3
	 */
	public function getName3()
	{
		if($this->_Name3 == null)
		{
			$this->_Name3 = new B3it_XmlBind_Bmecat12_Name3();
		}
		
		return $this->_Name3;
	}
	
	/**
	 * @param $value Name3
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setName3($value)
	{
		$this->_Name3 = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Contact
	 */
	public function getContact()
	{
		if($this->_Contact == null)
		{
			$this->_Contact = new B3it_XmlBind_Bmecat12_Contact();
		}
		
		return $this->_Contact;
	}
	
	/**
	 * @param $value Contact
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setContact($value)
	{
		$this->_Contact = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Street
	 */
	public function getStreet()
	{
		if($this->_Street == null)
		{
			$this->_Street = new B3it_XmlBind_Bmecat12_Street();
		}
		
		return $this->_Street;
	}
	
	/**
	 * @param $value Street
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setStreet($value)
	{
		$this->_Street = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Zip
	 */
	public function getZip()
	{
		if($this->_Zip == null)
		{
			$this->_Zip = new B3it_XmlBind_Bmecat12_Zip();
		}
		
		return $this->_Zip;
	}
	
	/**
	 * @param $value Zip
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setZip($value)
	{
		$this->_Zip = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Boxno
	 */
	public function getBoxno()
	{
		if($this->_Boxno == null)
		{
			$this->_Boxno = new B3it_XmlBind_Bmecat12_Boxno();
		}
		
		return $this->_Boxno;
	}
	
	/**
	 * @param $value Boxno
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setBoxno($value)
	{
		$this->_Boxno = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Zipbox
	 */
	public function getZipbox()
	{
		if($this->_Zipbox == null)
		{
			$this->_Zipbox = new B3it_XmlBind_Bmecat12_Zipbox();
		}
		
		return $this->_Zipbox;
	}
	
	/**
	 * @param $value Zipbox
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setZipbox($value)
	{
		$this->_Zipbox = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_City
	 */
	public function getCity()
	{
		if($this->_City == null)
		{
			$this->_City = new B3it_XmlBind_Bmecat12_City();
		}
		
		return $this->_City;
	}
	
	/**
	 * @param $value City
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCity($value)
	{
		$this->_City = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_State
	 */
	public function getState()
	{
		if($this->_State == null)
		{
			$this->_State = new B3it_XmlBind_Bmecat12_State();
		}
		
		return $this->_State;
	}
	
	/**
	 * @param $value State
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setState($value)
	{
		$this->_State = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Country
	 */
	public function getCountry()
	{
		if($this->_Country == null)
		{
			$this->_Country = new B3it_XmlBind_Bmecat12_Country();
		}
		
		return $this->_Country;
	}
	
	/**
	 * @param $value Country
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCountry($value)
	{
		$this->_Country = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Phone
	 */
	public function getPhone()
	{
		if($this->_Phone == null)
		{
			$this->_Phone = new B3it_XmlBind_Bmecat12_Phone();
		}
		
		return $this->_Phone;
	}
	
	/**
	 * @param $value Phone
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPhone($value)
	{
		$this->_Phone = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Fax
	 */
	public function getFax()
	{
		if($this->_Fax == null)
		{
			$this->_Fax = new B3it_XmlBind_Bmecat12_Fax();
		}
		
		return $this->_Fax;
	}
	
	/**
	 * @param $value Fax
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFax($value)
	{
		$this->_Fax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Email
	 */
	public function getEmail()
	{
		if($this->_Email == null)
		{
			$this->_Email = new B3it_XmlBind_Bmecat12_Email();
		}
		
		return $this->_Email;
	}
	
	/**
	 * @param $value Email
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setEmail($value)
	{
		$this->_Email = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_PublicKey[]
	 */
	public function getAllPublicKey()
	{
		return $this->_PublicKeys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_PublicKey and add it to list
	 * @return B3it_XmlBind_Bmecat12_PublicKey
	 */
	public function getPublicKey()
	{
		$res = new B3it_XmlBind_Bmecat12_PublicKey();
		$this->_PublicKeys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PublicKey[]
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPublicKey($value)
	{
		$this->_PublicKey = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Url
	 */
	public function getUrl()
	{
		if($this->_Url == null)
		{
			$this->_Url = new B3it_XmlBind_Bmecat12_Url();
		}
		
		return $this->_Url;
	}
	
	/**
	 * @param $value Url
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUrl($value)
	{
		$this->_Url = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_AddressRemarks
	 */
	public function getAddressRemarks()
	{
		if($this->_AddressRemarks == null)
		{
			$this->_AddressRemarks = new B3it_XmlBind_Bmecat12_AddressRemarks();
		}
		
		return $this->_AddressRemarks;
	}
	
	/**
	 * @param $value AddressRemarks
	 * @return B3it_XmlBind_Bmecat12_Typeaddress extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAddressRemarks($value)
	{
		$this->_AddressRemarks = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_Name != null){
			$this->_Name->toXml($xml);
		}
		if($this->_Name2 != null){
			$this->_Name2->toXml($xml);
		}
		if($this->_Name3 != null){
			$this->_Name3->toXml($xml);
		}
		if($this->_Contact != null){
			$this->_Contact->toXml($xml);
		}
		if($this->_Street != null){
			$this->_Street->toXml($xml);
		}
		if($this->_Zip != null){
			$this->_Zip->toXml($xml);
		}
		if($this->_Boxno != null){
			$this->_Boxno->toXml($xml);
		}
		if($this->_Zipbox != null){
			$this->_Zipbox->toXml($xml);
		}
		if($this->_City != null){
			$this->_City->toXml($xml);
		}
		if($this->_State != null){
			$this->_State->toXml($xml);
		}
		if($this->_Country != null){
			$this->_Country->toXml($xml);
		}
		if($this->_Phone != null){
			$this->_Phone->toXml($xml);
		}
		if($this->_Fax != null){
			$this->_Fax->toXml($xml);
		}
		if($this->_Email != null){
			$this->_Email->toXml($xml);
		}
		if($this->_PublicKeys != null){
			foreach($this->_PublicKeys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Url != null){
			$this->_Url->toXml($xml);
		}
		if($this->_AddressRemarks != null){
			$this->_AddressRemarks->toXml($xml);
		}

		return $xml;
	}
}