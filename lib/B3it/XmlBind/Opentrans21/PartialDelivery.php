<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	PartialDelivery
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_PartialDelivery extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Quantity */
	private $__Quantity = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryDate */
	private $__DeliveryDate = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Quantity
	 */
	public function getQuantity()
	{
		if($this->__Quantity == null)
		{
			$this->__Quantity = new B3it_XmlBind_Opentrans21_Quantity();
		}
	
		return $this->__Quantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Quantity
	 * @return B3it_XmlBind_Opentrans21_PartialDelivery
	 */
	public function setQuantity($value)
	{
		$this->__Quantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryDate
	 */
	public function getDeliveryDate()
	{
		if($this->__DeliveryDate == null)
		{
			$this->__DeliveryDate = new B3it_XmlBind_Opentrans21_DeliveryDate();
		}
	
		return $this->__DeliveryDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryDate
	 * @return B3it_XmlBind_Opentrans21_PartialDelivery
	 */
	public function setDeliveryDate($value)
	{
		$this->__DeliveryDate = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PARTIAL_DELIVERY');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Quantity != null){
			$this->__Quantity->toXml($xml);
		}
		if($this->__DeliveryDate != null){
			$this->__DeliveryDate->toXml($xml);
		}


		return $xml;
	}

}
