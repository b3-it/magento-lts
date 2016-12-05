<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Typeaddress
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Typeaddress extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Name */
	private $__NameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Name2 */
	private $__Name2A = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Name3 */
	private $__Name3A = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Department */
	private $__DepartmentA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ContactDetails */
	private $__ContactDetailsA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Contact */
	private $__ContactA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Street */
	private $__StreetA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Zip */
	private $__ZipA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Boxno */
	private $__BoxnoA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Zipbox */
	private $__ZipboxA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_City */
	private $__CityA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_State */
	private $__StateA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Country */
	private $__CountryA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CountryCoded */
	private $__CountryCoded = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_VatId */
	private $__VatId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Phone */
	private $__PhoneA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fax */
	private $__FaxA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Email */
	private $__Email = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PublicKey */
	private $__PublicKeyA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Url */
	private $__Url = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AddressRemarks */
	private $__AddressRemarksA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Name and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Name
	 */
	public function getName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Name();
		$this->__NameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Name
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setName($value)
	{
		$this->__NameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Name[]
	 */
	public function getAllName()
	{
		return $this->__NameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Name2 and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Name2
	 */
	public function getName2()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Name2();
		$this->__Name2A[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Name2
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setName2($value)
	{
		$this->__Name2A[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Name2[]
	 */
	public function getAllName2()
	{
		return $this->__Name2A;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Name3 and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Name3
	 */
	public function getName3()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Name3();
		$this->__Name3A[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Name3
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setName3($value)
	{
		$this->__Name3A[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Name3[]
	 */
	public function getAllName3()
	{
		return $this->__Name3A;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Department and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Department
	 */
	public function getDepartment()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Department();
		$this->__DepartmentA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Department
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setDepartment($value)
	{
		$this->__DepartmentA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Department[]
	 */
	public function getAllDepartment()
	{
		return $this->__DepartmentA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ContactDetails and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactDetails
	 */
	public function getContactDetails()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ContactDetails();
		$this->__ContactDetailsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ContactDetails
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setContactDetails($value)
	{
		$this->__ContactDetailsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactDetails[]
	 */
	public function getAllContactDetails()
	{
		return $this->__ContactDetailsA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Contact and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Contact
	 */
	public function getContact()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Contact();
		$this->__ContactA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Contact
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setContact($value)
	{
		$this->__ContactA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Contact[]
	 */
	public function getAllContact()
	{
		return $this->__ContactA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Street and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Street
	 */
	public function getStreet()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Street();
		$this->__StreetA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Street
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setStreet($value)
	{
		$this->__StreetA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Street[]
	 */
	public function getAllStreet()
	{
		return $this->__StreetA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Zip and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Zip
	 */
	public function getZip()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Zip();
		$this->__ZipA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Zip
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setZip($value)
	{
		$this->__ZipA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Zip[]
	 */
	public function getAllZip()
	{
		return $this->__ZipA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Boxno and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Boxno
	 */
	public function getBoxno()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Boxno();
		$this->__BoxnoA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Boxno
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setBoxno($value)
	{
		$this->__BoxnoA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Boxno[]
	 */
	public function getAllBoxno()
	{
		return $this->__BoxnoA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Zipbox and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Zipbox
	 */
	public function getZipbox()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Zipbox();
		$this->__ZipboxA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Zipbox
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setZipbox($value)
	{
		$this->__ZipboxA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Zipbox[]
	 */
	public function getAllZipbox()
	{
		return $this->__ZipboxA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_City and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_City
	 */
	public function getCity()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_City();
		$this->__CityA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_City
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setCity($value)
	{
		$this->__CityA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_City[]
	 */
	public function getAllCity()
	{
		return $this->__CityA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_State and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_State
	 */
	public function getState()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_State();
		$this->__StateA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_State
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setState($value)
	{
		$this->__StateA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_State[]
	 */
	public function getAllState()
	{
		return $this->__StateA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Country and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Country
	 */
	public function getCountry()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Country();
		$this->__CountryA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Country
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setCountry($value)
	{
		$this->__CountryA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Country[]
	 */
	public function getAllCountry()
	{
		return $this->__CountryA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CountryCoded
	 */
	public function getCountryCoded()
	{
		if($this->__CountryCoded == null)
		{
			$this->__CountryCoded = new B3it_XmlBind_Opentrans21_Bmecat_CountryCoded();
		}
	
		return $this->__CountryCoded;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CountryCoded
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setCountryCoded($value)
	{
		$this->__CountryCoded = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_VatId
	 */
	public function getVatId()
	{
		if($this->__VatId == null)
		{
			$this->__VatId = new B3it_XmlBind_Opentrans21_Bmecat_VatId();
		}
	
		return $this->__VatId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_VatId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setVatId($value)
	{
		$this->__VatId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Phone and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Phone
	 */
	public function getPhone()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Phone();
		$this->__PhoneA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Phone
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setPhone($value)
	{
		$this->__PhoneA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Phone[]
	 */
	public function getAllPhone()
	{
		return $this->__PhoneA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Fax and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fax
	 */
	public function getFax()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Fax();
		$this->__FaxA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fax
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setFax($value)
	{
		$this->__FaxA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fax[]
	 */
	public function getAllFax()
	{
		return $this->__FaxA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Email
	 */
	public function getEmail()
	{
		if($this->__Email == null)
		{
			$this->__Email = new B3it_XmlBind_Opentrans21_Bmecat_Email();
		}
	
		return $this->__Email;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Email
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setEmail($value)
	{
		$this->__Email = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PublicKey and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PublicKey
	 */
	public function getPublicKey()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PublicKey();
		$this->__PublicKeyA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PublicKey
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setPublicKey($value)
	{
		$this->__PublicKeyA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PublicKey[]
	 */
	public function getAllPublicKey()
	{
		return $this->__PublicKeyA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Url
	 */
	public function getUrl()
	{
		if($this->__Url == null)
		{
			$this->__Url = new B3it_XmlBind_Opentrans21_Bmecat_Url();
		}
	
		return $this->__Url;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Url
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setUrl($value)
	{
		$this->__Url = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AddressRemarks and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AddressRemarks
	 */
	public function getAddressRemarks()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AddressRemarks();
		$this->__AddressRemarksA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AddressRemarks
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeaddress
	 */
	public function setAddressRemarks($value)
	{
		$this->__AddressRemarksA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AddressRemarks[]
	 */
	public function getAllAddressRemarks()
	{
		return $this->__AddressRemarksA;
	}







	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__NameA != null){
			foreach($this->__NameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Name2A != null){
			foreach($this->__Name2A as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Name3A != null){
			foreach($this->__Name3A as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DepartmentA != null){
			foreach($this->__DepartmentA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ContactDetailsA != null){
			foreach($this->__ContactDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ContactA != null){
			foreach($this->__ContactA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StreetA != null){
			foreach($this->__StreetA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ZipA != null){
			foreach($this->__ZipA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__BoxnoA != null){
			foreach($this->__BoxnoA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ZipboxA != null){
			foreach($this->__ZipboxA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CityA != null){
			foreach($this->__CityA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StateA != null){
			foreach($this->__StateA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CountryA != null){
			foreach($this->__CountryA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CountryCoded != null){
			$this->__CountryCoded->toXml($xml);
		}
		if($this->__VatId != null){
			$this->__VatId->toXml($xml);
		}
		if($this->__PhoneA != null){
			foreach($this->__PhoneA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FaxA != null){
			foreach($this->__FaxA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Email != null){
			$this->__Email->toXml($xml);
		}
		if($this->__PublicKeyA != null){
			foreach($this->__PublicKeyA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Url != null){
			$this->__Url->toXml($xml);
		}
		if($this->__AddressRemarksA != null){
			foreach($this->__AddressRemarksA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
