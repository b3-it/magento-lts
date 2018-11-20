<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	Bkg_VirtualAccess_Model_Service_Webservice_
 * @name       	Freischaltung
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{
	
	
	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Auftrag */
	private $__Auftrag = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Service */
	private $__Service = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person */
	private $__Person = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart */
	private $__Nutzungsart = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges */
	private $__Sonstiges = null;


	

	

	
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Auftrag
	 */
	public function getAuftrag()
	{
		if($this->__Auftrag == null)
		{
			$this->__Auftrag = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Auftrag();
		}
	
		return $this->__Auftrag;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Auftrag
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung
	 */
	public function setAuftrag($value)
	{
		$this->__Auftrag = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Service
	 */
	public function getService()
	{
		if($this->__Service == null)
		{
			$this->__Service = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Service();
		}
	
		return $this->__Service;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Service
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung
	 */
	public function setService($value)
	{
		$this->__Service = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 */
	public function getPerson()
	{
		if($this->__Person == null)
		{
			$this->__Person = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person();
		}
	
		return $this->__Person;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Person
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung
	 */
	public function setPerson($value)
	{
		$this->__Person = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 */
	public function getNutzungsart()
	{
		if($this->__Nutzungsart == null)
		{
			$this->__Nutzungsart = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart();
		}
	
		return $this->__Nutzungsart;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung
	 */
	public function setNutzungsart($value)
	{
		$this->__Nutzungsart = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges
	 */
	public function getSonstiges()
	{
		if($this->__Sonstiges == null)
		{
			$this->__Sonstiges = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges();
		}
	
		return $this->__Sonstiges;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung
	 */
	public function setSonstiges($value)
	{
		$this->__Sonstiges = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('freischaltung');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Auftrag != null){
			$this->__Auftrag->toXml($xml);
		}
		if($this->__Service != null){
			$this->__Service->toXml($xml);
		}
		if($this->__Person != null){
			$this->__Person->toXml($xml);
		}
		if($this->__Nutzungsart != null){
			$this->__Nutzungsart->toXml($xml);
		}
		if($this->__Sonstiges != null){
			$this->__Sonstiges->toXml($xml);
		}


		return $xml;
	}

}
