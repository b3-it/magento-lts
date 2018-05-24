<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	Bkg_VirtualAccess_Model_Service_Webservice_
 * @name       	Freischaltung_Person
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{
	
	
	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Name */
	private $__Name = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Vorname */
	private $__Vorname = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Telefon */
	private $__Telefon = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Email */
	private $__Email = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_PersonId */
	private $__PersonId = null;


	

	

	
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Name
	 */
	public function getName()
	{
		if($this->__Name == null)
		{
			$this->__Name = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Name();
		}
	
		return $this->__Name;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Name
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 */
	public function setName($value)
	{
		$this->__Name = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Vorname
	 */
	public function getVorname()
	{
		if($this->__Vorname == null)
		{
			$this->__Vorname = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Vorname();
		}
	
		return $this->__Vorname;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Vorname
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 */
	public function setVorname($value)
	{
		$this->__Vorname = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Telefon
	 */
	public function getTelefon()
	{
		if($this->__Telefon == null)
		{
			$this->__Telefon = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Telefon();
		}
	
		return $this->__Telefon;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Telefon
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 */
	public function setTelefon($value)
	{
		$this->__Telefon = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Email
	 */
	public function getEmail()
	{
		if($this->__Email == null)
		{
			$this->__Email = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Email();
		}
	
		return $this->__Email;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_Email
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 */
	public function setEmail($value)
	{
		$this->__Email = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_PersonId
	 */
	public function getPersonId()
	{
		if($this->__PersonId == null)
		{
			$this->__PersonId = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_PersonId();
		}
	
		return $this->__PersonId;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person_PersonId
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 */
	public function setPersonId($value)
	{
		$this->__PersonId = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('person');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Name != null){
			$this->__Name->toXml($xml);
		}
		if($this->__Vorname != null){
			$this->__Vorname->toXml($xml);
		}
		if($this->__Telefon != null){
			$this->__Telefon->toXml($xml);
		}
		if($this->__Email != null){
			$this->__Email->toXml($xml);
		}
		if($this->__PersonId != null){
			$this->__PersonId->toXml($xml);
		}


		return $xml;
	}

}
