<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ShipmentPartiesReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ShipmentPartiesReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DeliveryIdref */
	private $__DeliveryIdref = null;

	/* @var B3it_XmlBind_Opentrans21_FinalDeliveryIdref */
	private $__FinalDeliveryIdref = null;

	/* @var B3it_XmlBind_Opentrans21_DelivererIdref */
	private $__DelivererIdref = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryIdref
	 */
	public function getDeliveryIdref()
	{
		if($this->__DeliveryIdref == null)
		{
			$this->__DeliveryIdref = new B3it_XmlBind_Opentrans21_DeliveryIdref();
		}
	
		return $this->__DeliveryIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryIdref
	 * @return B3it_XmlBind_Opentrans21_ShipmentPartiesReference
	 */
	public function setDeliveryIdref($value)
	{
		$this->__DeliveryIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_FinalDeliveryIdref
	 */
	public function getFinalDeliveryIdref()
	{
		if($this->__FinalDeliveryIdref == null)
		{
			$this->__FinalDeliveryIdref = new B3it_XmlBind_Opentrans21_FinalDeliveryIdref();
		}
	
		return $this->__FinalDeliveryIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_FinalDeliveryIdref
	 * @return B3it_XmlBind_Opentrans21_ShipmentPartiesReference
	 */
	public function setFinalDeliveryIdref($value)
	{
		$this->__FinalDeliveryIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DelivererIdref
	 */
	public function getDelivererIdref()
	{
		if($this->__DelivererIdref == null)
		{
			$this->__DelivererIdref = new B3it_XmlBind_Opentrans21_DelivererIdref();
		}
	
		return $this->__DelivererIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DelivererIdref
	 * @return B3it_XmlBind_Opentrans21_ShipmentPartiesReference
	 */
	public function setDelivererIdref($value)
	{
		$this->__DelivererIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('SHIPMENT_PARTIES_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DeliveryIdref != null){
			$this->__DeliveryIdref->toXml($xml);
		}
		if($this->__FinalDeliveryIdref != null){
			$this->__FinalDeliveryIdref->toXml($xml);
		}
		if($this->__DelivererIdref != null){
			$this->__DelivererIdref->toXml($xml);
		}


		return $xml;
	}

}
