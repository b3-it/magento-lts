<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ContactDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ContactDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ContactId */
	private $__ContactId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ContactName */
	private $__ContactNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FirstName */
	private $__FirstNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Title */
	private $__TitleA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AcademicTitle */
	private $__AcademicTitleA = array();

	
	/* @var B3it_XmlBind_Opentrans21_ContactRole */
	private $__ContactRoleA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ContactDescr */
	private $__ContactDescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Phone */
	private $__PhoneA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fax */
	private $__FaxA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Url */
	private $__Url = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Emails */
	private $__Emails = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Authentification */
	private $__Authentification = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactId
	 */
	public function getContactId()
	{
		if($this->__ContactId == null)
		{
			$this->__ContactId = new B3it_XmlBind_Opentrans21_Bmecat_ContactId();
		}
	
		return $this->__ContactId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ContactId
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setContactId($value)
	{
		$this->__ContactId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ContactName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactName
	 */
	public function getContactName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ContactName();
		$this->__ContactNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ContactName
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setContactName($value)
	{
		$this->__ContactNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactName[]
	 */
	public function getAllContactName()
	{
		return $this->__ContactNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FirstName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FirstName
	 */
	public function getFirstName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FirstName();
		$this->__FirstNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FirstName
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setFirstName($value)
	{
		$this->__FirstNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FirstName[]
	 */
	public function getAllFirstName()
	{
		return $this->__FirstNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Title and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Title
	 */
	public function getTitle()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Title();
		$this->__TitleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Title
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setTitle($value)
	{
		$this->__TitleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Title[]
	 */
	public function getAllTitle()
	{
		return $this->__TitleA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AcademicTitle and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AcademicTitle
	 */
	public function getAcademicTitle()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AcademicTitle();
		$this->__AcademicTitleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AcademicTitle
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setAcademicTitle($value)
	{
		$this->__AcademicTitleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AcademicTitle[]
	 */
	public function getAllAcademicTitle()
	{
		return $this->__AcademicTitleA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_ContactRole and add it to list
	 * @return B3it_XmlBind_Opentrans21_ContactRole
	 */
	public function getContactRole()
	{
		$res = new B3it_XmlBind_Opentrans21_ContactRole();
		$this->__ContactRoleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ContactRole
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setContactRole($value)
	{
		$this->__ContactRoleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ContactRole[]
	 */
	public function getAllContactRole()
	{
		return $this->__ContactRoleA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ContactDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactDescr
	 */
	public function getContactDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ContactDescr();
		$this->__ContactDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ContactDescr
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setContactDescr($value)
	{
		$this->__ContactDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ContactDescr[]
	 */
	public function getAllContactDescr()
	{
		return $this->__ContactDescrA;
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
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
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
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
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
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setUrl($value)
	{
		$this->__Url = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Emails
	 */
	public function getEmails()
	{
		if($this->__Emails == null)
		{
			$this->__Emails = new B3it_XmlBind_Opentrans21_Bmecat_Emails();
		}
	
		return $this->__Emails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Emails
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setEmails($value)
	{
		$this->__Emails = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Authentification
	 */
	public function getAuthentification()
	{
		if($this->__Authentification == null)
		{
			$this->__Authentification = new B3it_XmlBind_Opentrans21_Bmecat_Authentification();
		}
	
		return $this->__Authentification;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Authentification
	 * @return B3it_XmlBind_Opentrans21_ContactDetails
	 */
	public function setAuthentification($value)
	{
		$this->__Authentification = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('CONTACT_DETAILS');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ContactId != null){
			$this->__ContactId->toXml($xml);
		}
		if($this->__ContactNameA != null){
			foreach($this->__ContactNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FirstNameA != null){
			foreach($this->__FirstNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__TitleA != null){
			foreach($this->__TitleA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AcademicTitleA != null){
			foreach($this->__AcademicTitleA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ContactRoleA != null){
			foreach($this->__ContactRoleA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ContactDescrA != null){
			foreach($this->__ContactDescrA as $item){
				$item->toXml($xml);
			}
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
		if($this->__Url != null){
			$this->__Url->toXml($xml);
		}
		if($this->__Emails != null){
			$this->__Emails->toXml($xml);
		}
		if($this->__Authentification != null){
			$this->__Authentification->toXml($xml);
		}


		return $xml;
	}

}
