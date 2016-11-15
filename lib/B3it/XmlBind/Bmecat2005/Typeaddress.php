<?php
class B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Name */
	private $_Names = array();	

	/* @var Name2 */
	private $_Name2s = array();	

	/* @var Name3 */
	private $_Name3s = array();	

	/* @var Department */
	private $_Departments = array();	

	/* @var ContactDetails */
	private $_ContactDetailss = array();	

	/* @var Contact */
	private $_Contacts = array();	

	/* @var Street */
	private $_Streets = array();	

	/* @var Zip */
	private $_Zips = array();	

	/* @var Boxno */
	private $_Boxnos = array();	

	/* @var Zipbox */
	private $_Zipboxs = array();	

	/* @var City */
	private $_Citys = array();	

	/* @var State */
	private $_States = array();	

	/* @var Country */
	private $_Countrys = array();	

	/* @var CountryCoded */
	private $_CountryCoded = null;	

	/* @var VatId */
	private $_VatId = null;	

	/* @var Phone */
	private $_Phones = array();	

	/* @var Fax */
	private $_Faxs = array();	

	/* @var Email */
	private $_Email = null;	

	/* @var PublicKey */
	private $_PublicKeys = array();	

	/* @var Url */
	private $_Url = null;	

	/* @var AddressRemarks */
	private $_AddressRemarkss = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Name[]
	 */
	public function getAllName()
	{
		return $this->_Names;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Name and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Name
	 */
	public function getName()
	{
		$res = new B3it_XmlBind_Bmecat2005_Name();
		$this->_Names[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Name[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setName($value)
	{
		$this->_Name = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Name2[]
	 */
	public function getAllName2()
	{
		return $this->_Name2s;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Name2 and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Name2
	 */
	public function getName2()
	{
		$res = new B3it_XmlBind_Bmecat2005_Name2();
		$this->_Name2s[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Name2[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setName2($value)
	{
		$this->_Name2 = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Name3[]
	 */
	public function getAllName3()
	{
		return $this->_Name3s;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Name3 and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Name3
	 */
	public function getName3()
	{
		$res = new B3it_XmlBind_Bmecat2005_Name3();
		$this->_Name3s[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Name3[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setName3($value)
	{
		$this->_Name3 = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Department[]
	 */
	public function getAllDepartment()
	{
		return $this->_Departments;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Department and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Department
	 */
	public function getDepartment()
	{
		$res = new B3it_XmlBind_Bmecat2005_Department();
		$this->_Departments[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Department[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDepartment($value)
	{
		$this->_Department = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails[]
	 */
	public function getAllContactDetails()
	{
		return $this->_ContactDetailss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ContactDetails and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails
	 */
	public function getContactDetails()
	{
		$res = new B3it_XmlBind_Bmecat2005_ContactDetails();
		$this->_ContactDetailss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ContactDetails[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContactDetails($value)
	{
		$this->_ContactDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Contact[]
	 */
	public function getAllContact()
	{
		return $this->_Contacts;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Contact and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Contact
	 */
	public function getContact()
	{
		$res = new B3it_XmlBind_Bmecat2005_Contact();
		$this->_Contacts[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Contact[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContact($value)
	{
		$this->_Contact = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Street[]
	 */
	public function getAllStreet()
	{
		return $this->_Streets;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Street and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Street
	 */
	public function getStreet()
	{
		$res = new B3it_XmlBind_Bmecat2005_Street();
		$this->_Streets[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Street[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStreet($value)
	{
		$this->_Street = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Zip[]
	 */
	public function getAllZip()
	{
		return $this->_Zips;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Zip and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Zip
	 */
	public function getZip()
	{
		$res = new B3it_XmlBind_Bmecat2005_Zip();
		$this->_Zips[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Zip[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setZip($value)
	{
		$this->_Zip = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Boxno[]
	 */
	public function getAllBoxno()
	{
		return $this->_Boxnos;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Boxno and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Boxno
	 */
	public function getBoxno()
	{
		$res = new B3it_XmlBind_Bmecat2005_Boxno();
		$this->_Boxnos[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Boxno[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setBoxno($value)
	{
		$this->_Boxno = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Zipbox[]
	 */
	public function getAllZipbox()
	{
		return $this->_Zipboxs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Zipbox and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Zipbox
	 */
	public function getZipbox()
	{
		$res = new B3it_XmlBind_Bmecat2005_Zipbox();
		$this->_Zipboxs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Zipbox[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setZipbox($value)
	{
		$this->_Zipbox = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_City[]
	 */
	public function getAllCity()
	{
		return $this->_Citys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_City and add it to list
	 * @return B3it_XmlBind_Bmecat2005_City
	 */
	public function getCity()
	{
		$res = new B3it_XmlBind_Bmecat2005_City();
		$this->_Citys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value City[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCity($value)
	{
		$this->_City = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_State[]
	 */
	public function getAllState()
	{
		return $this->_States;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_State and add it to list
	 * @return B3it_XmlBind_Bmecat2005_State
	 */
	public function getState()
	{
		$res = new B3it_XmlBind_Bmecat2005_State();
		$this->_States[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value State[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setState($value)
	{
		$this->_State = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Country[]
	 */
	public function getAllCountry()
	{
		return $this->_Countrys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Country and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Country
	 */
	public function getCountry()
	{
		$res = new B3it_XmlBind_Bmecat2005_Country();
		$this->_Countrys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Country[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCountry($value)
	{
		$this->_Country = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CountryCoded
	 */
	public function getCountryCoded()
	{
		if($this->_CountryCoded == null)
		{
			$this->_CountryCoded = new B3it_XmlBind_Bmecat2005_CountryCoded();
		}
		
		return $this->_CountryCoded;
	}
	
	/**
	 * @param $value CountryCoded
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCountryCoded($value)
	{
		$this->_CountryCoded = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_VatId
	 */
	public function getVatId()
	{
		if($this->_VatId == null)
		{
			$this->_VatId = new B3it_XmlBind_Bmecat2005_VatId();
		}
		
		return $this->_VatId;
	}
	
	/**
	 * @param $value VatId
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setVatId($value)
	{
		$this->_VatId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Phone[]
	 */
	public function getAllPhone()
	{
		return $this->_Phones;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Phone and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Phone
	 */
	public function getPhone()
	{
		$res = new B3it_XmlBind_Bmecat2005_Phone();
		$this->_Phones[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Phone[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPhone($value)
	{
		$this->_Phone = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Fax[]
	 */
	public function getAllFax()
	{
		return $this->_Faxs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Fax and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Fax
	 */
	public function getFax()
	{
		$res = new B3it_XmlBind_Bmecat2005_Fax();
		$this->_Faxs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Fax[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFax($value)
	{
		$this->_Fax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Email
	 */
	public function getEmail()
	{
		if($this->_Email == null)
		{
			$this->_Email = new B3it_XmlBind_Bmecat2005_Email();
		}
		
		return $this->_Email;
	}
	
	/**
	 * @param $value Email
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setEmail($value)
	{
		$this->_Email = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PublicKey[]
	 */
	public function getAllPublicKey()
	{
		return $this->_PublicKeys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PublicKey and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PublicKey
	 */
	public function getPublicKey()
	{
		$res = new B3it_XmlBind_Bmecat2005_PublicKey();
		$this->_PublicKeys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PublicKey[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPublicKey($value)
	{
		$this->_PublicKey = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Url
	 */
	public function getUrl()
	{
		if($this->_Url == null)
		{
			$this->_Url = new B3it_XmlBind_Bmecat2005_Url();
		}
		
		return $this->_Url;
	}
	
	/**
	 * @param $value Url
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUrl($value)
	{
		$this->_Url = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AddressRemarks[]
	 */
	public function getAllAddressRemarks()
	{
		return $this->_AddressRemarkss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AddressRemarks and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AddressRemarks
	 */
	public function getAddressRemarks()
	{
		$res = new B3it_XmlBind_Bmecat2005_AddressRemarks();
		$this->_AddressRemarkss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AddressRemarks[]
	 * @return B3it_XmlBind_Bmecat2005_Typeaddress extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAddressRemarks($value)
	{
		$this->_AddressRemarks = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_Names != null){
			foreach($this->_Names as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Name2s != null){
			foreach($this->_Name2s as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Name3s != null){
			foreach($this->_Name3s as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Departments != null){
			foreach($this->_Departments as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ContactDetailss != null){
			foreach($this->_ContactDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Contacts != null){
			foreach($this->_Contacts as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Streets != null){
			foreach($this->_Streets as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Zips != null){
			foreach($this->_Zips as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Boxnos != null){
			foreach($this->_Boxnos as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Zipboxs != null){
			foreach($this->_Zipboxs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Citys != null){
			foreach($this->_Citys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_States != null){
			foreach($this->_States as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Countrys != null){
			foreach($this->_Countrys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_CountryCoded != null){
			$this->_CountryCoded->toXml($xml);
		}
		if($this->_VatId != null){
			$this->_VatId->toXml($xml);
		}
		if($this->_Phones != null){
			foreach($this->_Phones as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Faxs != null){
			foreach($this->_Faxs as $item){
				$item->toXml($xml);
			}
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
		if($this->_AddressRemarkss != null){
			foreach($this->_AddressRemarkss as $item){
				$item->toXml($xml);
			}
		}

		return $xml;
	}
}