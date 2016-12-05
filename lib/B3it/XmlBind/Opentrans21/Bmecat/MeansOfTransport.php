<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_MeansOfTransport
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportId */
	private $__MeansOfTransportId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportName */
	private $__MeansOfTransportNameA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportId
	 */
	public function getMeansOfTransportId()
	{
		if($this->__MeansOfTransportId == null)
		{
			$this->__MeansOfTransportId = new B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportId();
		}
	
		return $this->__MeansOfTransportId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport
	 */
	public function setMeansOfTransportId($value)
	{
		$this->__MeansOfTransportId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportName
	 */
	public function getMeansOfTransportName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportName();
		$this->__MeansOfTransportNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport
	 */
	public function setMeansOfTransportName($value)
	{
		$this->__MeansOfTransportNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransportName[]
	 */
	public function getAllMeansOfTransportName()
	{
		return $this->__MeansOfTransportNameA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:MEANS_OF_TRANSPORT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:MEANS_OF_TRANSPORT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__MeansOfTransportId != null){
			$this->__MeansOfTransportId->toXml($xml);
		}
		if($this->__MeansOfTransportNameA != null){
			foreach($this->__MeansOfTransportNameA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
