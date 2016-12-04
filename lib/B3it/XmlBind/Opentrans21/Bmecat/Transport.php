<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Transport
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Transport extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Incoterm */
	private $__Incoterm = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Location */
	private $__Location = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_TransportRemark */
	private $__TransportRemarkA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Incoterm
	 */
	public function getIncoterm()
	{
		if($this->__Incoterm == null)
		{
			$this->__Incoterm = new B3it_XmlBind_Opentrans21_Bmecat_Incoterm();
		}
	
		return $this->__Incoterm;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Incoterm
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport
	 */
	public function setIncoterm($value)
	{
		$this->__Incoterm = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Location
	 */
	public function getLocation()
	{
		if($this->__Location == null)
		{
			$this->__Location = new B3it_XmlBind_Opentrans21_Bmecat_Location();
		}
	
		return $this->__Location;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Location
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport
	 */
	public function setLocation($value)
	{
		$this->__Location = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_TransportRemark and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TransportRemark
	 */
	public function getTransportRemark()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_TransportRemark();
		$this->__TransportRemarkA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TransportRemark
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport
	 */
	public function setTransportRemark($value)
	{
		$this->__TransportRemarkA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TransportRemark[]
	 */
	public function getAllTransportRemark()
	{
		return $this->__TransportRemarkA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:TRANSPORT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:TRANSPORT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Incoterm != null){
			$this->__Incoterm->toXml($xml);
		}
		if($this->__Location != null){
			$this->__Location->toXml($xml);
		}
		if($this->__TransportRemarkA != null){
			foreach($this->__TransportRemarkA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
