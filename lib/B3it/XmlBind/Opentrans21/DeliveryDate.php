<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DeliveryDate
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DeliveryDate extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DeliveryStartDate */
	private $__DeliveryStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryEndDate */
	private $__DeliveryEndDate = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryStartDate
	 */
	public function getDeliveryStartDate()
	{
		if($this->__DeliveryStartDate == null)
		{
			$this->__DeliveryStartDate = new B3it_XmlBind_Opentrans21_DeliveryStartDate();
		}
	
		return $this->__DeliveryStartDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryStartDate
	 * @return B3it_XmlBind_Opentrans21_DeliveryDate
	 */
	public function setDeliveryStartDate($value)
	{
		$this->__DeliveryStartDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliveryEndDate
	 */
	public function getDeliveryEndDate()
	{
		if($this->__DeliveryEndDate == null)
		{
			$this->__DeliveryEndDate = new B3it_XmlBind_Opentrans21_DeliveryEndDate();
		}
	
		return $this->__DeliveryEndDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliveryEndDate
	 * @return B3it_XmlBind_Opentrans21_DeliveryDate
	 */
	public function setDeliveryEndDate($value)
	{
		$this->__DeliveryEndDate = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DELIVERY_DATE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DeliveryStartDate != null){
			$this->__DeliveryStartDate->toXml($xml);
		}
		if($this->__DeliveryEndDate != null){
			$this->__DeliveryEndDate->toXml($xml);
		}


		return $xml;
	}

}
