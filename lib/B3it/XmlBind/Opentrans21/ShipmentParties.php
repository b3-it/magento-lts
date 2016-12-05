<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ShipmentParties
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ShipmentParties extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DeliveryParty */
	private $__DeliveryParty = null;

	/* @var B3it_XmlBind_Opentrans21_FinalDeliveryParty */
	private $__FinalDeliveryParty = null;

	
	/* @var B3it_XmlBind_Opentrans21_TransportParty */
	private $__TransportPartyA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryParty
	 */
	public function getDeliveryParty()
	{
		if($this->__DeliveryParty == null)
		{
			$this->__DeliveryParty = new B3it_XmlBind_Opentrans21_DeliveryParty();
		}
	
		return $this->__DeliveryParty;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryParty
	 * @return B3it_XmlBind_Opentrans21_ShipmentParties
	 */
	public function setDeliveryParty($value)
	{
		$this->__DeliveryParty = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_FinalDeliveryParty
	 */
	public function getFinalDeliveryParty()
	{
		if($this->__FinalDeliveryParty == null)
		{
			$this->__FinalDeliveryParty = new B3it_XmlBind_Opentrans21_FinalDeliveryParty();
		}
	
		return $this->__FinalDeliveryParty;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_FinalDeliveryParty
	 * @return B3it_XmlBind_Opentrans21_ShipmentParties
	 */
	public function setFinalDeliveryParty($value)
	{
		$this->__FinalDeliveryParty = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TransportParty and add it to list
	 * @return B3it_XmlBind_Opentrans21_TransportParty
	 */
	public function getTransportParty()
	{
		$res = new B3it_XmlBind_Opentrans21_TransportParty();
		$this->__TransportPartyA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TransportParty
	 * @return B3it_XmlBind_Opentrans21_ShipmentParties
	 */
	public function setTransportParty($value)
	{
		$this->__TransportPartyA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TransportParty[]
	 */
	public function getAllTransportParty()
	{
		return $this->__TransportPartyA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('SHIPMENT_PARTIES');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DeliveryParty != null){
			$this->__DeliveryParty->toXml($xml);
		}
		if($this->__FinalDeliveryParty != null){
			$this->__FinalDeliveryParty->toXml($xml);
		}
		if($this->__TransportPartyA != null){
			foreach($this->__TransportPartyA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
