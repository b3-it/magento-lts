<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DeliveryReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DeliveryReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DeliverynoteId */
	private $__DeliverynoteId = null;

	/* @var B3it_XmlBind_Opentrans21_LineItemId */
	private $__LineItemId = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryDate */
	private $__DeliveryDate = null;

	/* @var B3it_XmlBind_Opentrans21_DeliveryIdref */
	private $__DeliveryIdref = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DeliverynoteId
	 */
	public function getDeliverynoteId()
	{
		if($this->__DeliverynoteId == null)
		{
			$this->__DeliverynoteId = new B3it_XmlBind_Opentrans21_DeliverynoteId();
		}
	
		return $this->__DeliverynoteId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DeliverynoteId
	 * @return B3it_XmlBind_Opentrans21_DeliveryReference
	 */
	public function setDeliverynoteId($value)
	{
		$this->__DeliverynoteId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_LineItemId
	 */
	public function getLineItemId()
	{
		if($this->__LineItemId == null)
		{
			$this->__LineItemId = new B3it_XmlBind_Opentrans21_LineItemId();
		}
	
		return $this->__LineItemId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_LineItemId
	 * @return B3it_XmlBind_Opentrans21_DeliveryReference
	 */
	public function setLineItemId($value)
	{
		$this->__LineItemId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_DeliveryReference
	 */
	public function setDeliveryDate($value)
	{
		$this->__DeliveryDate = $value;
		return $this;
	}
	
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
	 * @return B3it_XmlBind_Opentrans21_DeliveryReference
	 */
	public function setDeliveryIdref($value)
	{
		$this->__DeliveryIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DELIVERY_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DeliverynoteId != null){
			$this->__DeliverynoteId->toXml($xml);
		}
		if($this->__LineItemId != null){
			$this->__LineItemId->toXml($xml);
		}
		if($this->__DeliveryDate != null){
			$this->__DeliveryDate->toXml($xml);
		}
		if($this->__DeliveryIdref != null){
			$this->__DeliveryIdref->toXml($xml);
		}


		return $xml;
	}

}
