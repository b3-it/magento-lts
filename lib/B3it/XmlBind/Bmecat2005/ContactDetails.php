<?php
class B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ContactId */
	private $_ContactId = null;	

	/* @var ContactName */
	private $_ContactNames = array();	

	/* @var FirstName */
	private $_FirstNames = array();	

	/* @var Title */
	private $_Titles = array();	

	/* @var AcademicTitle */
	private $_AcademicTitles = array();	

	/* @var ContactRole */
	private $_ContactRoles = array();	

	/* @var ContactDescr */
	private $_ContactDescrs = array();	

	/* @var Phone */
	private $_Phones = array();	

	/* @var Fax */
	private $_Faxs = array();	

	/* @var Url */
	private $_Url = null;	

	/* @var Emails */
	private $_Emails = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ContactId
	 */
	public function getContactId()
	{
		if($this->_ContactId == null)
		{
			$this->_ContactId = new B3it_XmlBind_Bmecat2005_ContactId();
		}
		
		return $this->_ContactId;
	}
	
	/**
	 * @param $value ContactId
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContactId($value)
	{
		$this->_ContactId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ContactName[]
	 */
	public function getAllContactName()
	{
		return $this->_ContactNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ContactName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ContactName
	 */
	public function getContactName()
	{
		$res = new B3it_XmlBind_Bmecat2005_ContactName();
		$this->_ContactNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ContactName[]
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContactName($value)
	{
		$this->_ContactName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FirstName[]
	 */
	public function getAllFirstName()
	{
		return $this->_FirstNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FirstName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FirstName
	 */
	public function getFirstName()
	{
		$res = new B3it_XmlBind_Bmecat2005_FirstName();
		$this->_FirstNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FirstName[]
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFirstName($value)
	{
		$this->_FirstName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Title[]
	 */
	public function getAllTitle()
	{
		return $this->_Titles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Title and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Title
	 */
	public function getTitle()
	{
		$res = new B3it_XmlBind_Bmecat2005_Title();
		$this->_Titles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Title[]
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTitle($value)
	{
		$this->_Title = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AcademicTitle[]
	 */
	public function getAllAcademicTitle()
	{
		return $this->_AcademicTitles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AcademicTitle and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AcademicTitle
	 */
	public function getAcademicTitle()
	{
		$res = new B3it_XmlBind_Bmecat2005_AcademicTitle();
		$this->_AcademicTitles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AcademicTitle[]
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAcademicTitle($value)
	{
		$this->_AcademicTitle = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ContactRole[]
	 */
	public function getAllContactRole()
	{
		return $this->_ContactRoles;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ContactRole and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ContactRole
	 */
	public function getContactRole()
	{
		$res = new B3it_XmlBind_Bmecat2005_ContactRole();
		$this->_ContactRoles[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ContactRole[]
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContactRole($value)
	{
		$this->_ContactRole = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ContactDescr[]
	 */
	public function getAllContactDescr()
	{
		return $this->_ContactDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ContactDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ContactDescr
	 */
	public function getContactDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_ContactDescr();
		$this->_ContactDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ContactDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContactDescr($value)
	{
		$this->_ContactDescr = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFax($value)
	{
		$this->_Fax = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUrl($value)
	{
		$this->_Url = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Emails
	 */
	public function getEmails()
	{
		if($this->_Emails == null)
		{
			$this->_Emails = new B3it_XmlBind_Bmecat2005_Emails();
		}
		
		return $this->_Emails;
	}
	
	/**
	 * @param $value Emails
	 * @return B3it_XmlBind_Bmecat2005_ContactDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setEmails($value)
	{
		$this->_Emails = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CONTACT_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ContactId != null){
			$this->_ContactId->toXml($xml);
		}
		if($this->_ContactNames != null){
			foreach($this->_ContactNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FirstNames != null){
			foreach($this->_FirstNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Titles != null){
			foreach($this->_Titles as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AcademicTitles != null){
			foreach($this->_AcademicTitles as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ContactRoles != null){
			foreach($this->_ContactRoles as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ContactDescrs != null){
			foreach($this->_ContactDescrs as $item){
				$item->toXml($xml);
			}
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
		if($this->_Url != null){
			$this->_Url->toXml($xml);
		}
		if($this->_Emails != null){
			$this->_Emails->toXml($xml);
		}


		return $xml;
	}
}