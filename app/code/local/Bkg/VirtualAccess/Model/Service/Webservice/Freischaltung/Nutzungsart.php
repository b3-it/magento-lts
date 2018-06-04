<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	Bkg_VirtualAccess_Model_Service_Webservice_
 * @name       	Freischaltung_Nutzungsart
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{
	
	
	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Lizenztyp */
	private $__Lizenztyp = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsnummer */
	private $__Vertragsnummer = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragseingang */
	private $__Vertragseingang = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsende */
	private $__Vertragsende = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Dienstende */
	private $__Dienstende = null;


	

	

	
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Lizenztyp
	 */
	public function getLizenztyp()
	{
		if($this->__Lizenztyp == null)
		{
			$this->__Lizenztyp = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Lizenztyp();
		}
	
		return $this->__Lizenztyp;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Lizenztyp
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 */
	public function setLizenztyp($value)
	{
		$this->__Lizenztyp = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsnummer
	 */
	public function getVertragsnummer()
	{
		if($this->__Vertragsnummer == null)
		{
			$this->__Vertragsnummer = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsnummer();
		}
	
		return $this->__Vertragsnummer;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsnummer
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 */
	public function setVertragsnummer($value)
	{
		$this->__Vertragsnummer = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragseingang
	 */
	public function getVertragseingang()
	{
		if($this->__Vertragseingang == null)
		{
			$this->__Vertragseingang = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragseingang();
		}
	
		return $this->__Vertragseingang;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragseingang
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 */
	public function setVertragseingang($value)
	{
		$this->__Vertragseingang = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsende
	 */
	public function getVertragsende()
	{
		if($this->__Vertragsende == null)
		{
			$this->__Vertragsende = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsende();
		}
	
		return $this->__Vertragsende;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Vertragsende
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 */
	public function setVertragsende($value)
	{
		$this->__Vertragsende = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Dienstende
	 */
	public function getDienstende()
	{
		if($this->__Dienstende == null)
		{
			$this->__Dienstende = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Dienstende();
		}
	
		return $this->__Dienstende;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart_Dienstende
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Nutzungsart
	 */
	public function setDienstende($value)
	{
		$this->__Dienstende = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('nutzungsart');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Lizenztyp != null){
			$this->__Lizenztyp->toXml($xml);
		}
		if($this->__Vertragsnummer != null){
			$this->__Vertragsnummer->toXml($xml);
		}
		if($this->__Vertragseingang != null){
			$this->__Vertragseingang->toXml($xml);
		}
		if($this->__Vertragsende != null){
			$this->__Vertragsende->toXml($xml);
		}
		if($this->__Dienstende != null){
			$this->__Dienstende->toXml($xml);
		}


		return $xml;
	}

}
