<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	Bkg_VirtualAccess_Model_Service_Webservice_
 * @name       	Freischaltung_Sonstiges
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges extends Bkg_VirtualAccess_Model_Service_Webservice_XmlObject
{
	
	
	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Zugriffswunsch */
	private $__Zugriffswunsch = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Auftragsart */
	private $__Auftragsart = null;

	/* @var Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Abrechnungsmodell */
	private $__Abrechnungsmodell = null;


	

	

	
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Zugriffswunsch
	 */
	public function getZugriffswunsch()
	{
		if($this->__Zugriffswunsch == null)
		{
			$this->__Zugriffswunsch = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Zugriffswunsch();
		}
	
		return $this->__Zugriffswunsch;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Zugriffswunsch
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges
	 */
	public function setZugriffswunsch($value)
	{
		$this->__Zugriffswunsch = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Auftragsart
	 */
	public function getAuftragsart()
	{
		if($this->__Auftragsart == null)
		{
			$this->__Auftragsart = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Auftragsart();
		}
	
		return $this->__Auftragsart;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Auftragsart
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges
	 */
	public function setAuftragsart($value)
	{
		$this->__Auftragsart = $value;
		return $this;
	}
	
	/**
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Abrechnungsmodell
	 */
	public function getAbrechnungsmodell()
	{
		if($this->__Abrechnungsmodell == null)
		{
			$this->__Abrechnungsmodell = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Abrechnungsmodell();
		}
	
		return $this->__Abrechnungsmodell;
	}
	
	/**
	 * @param $value Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges_Abrechnungsmodell
	 * @return Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung_Sonstiges
	 */
	public function setAbrechnungsmodell($value)
	{
		$this->__Abrechnungsmodell = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('sonstiges');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Zugriffswunsch != null){
			$this->__Zugriffswunsch->toXml($xml);
		}
		if($this->__Auftragsart != null){
			$this->__Auftragsart->toXml($xml);
		}
		if($this->__Abrechnungsmodell != null){
			$this->__Abrechnungsmodell->toXml($xml);
		}


		return $xml;
	}

}
