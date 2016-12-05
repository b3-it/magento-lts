<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Card
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Card extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_CardNum */
	private $__CardNum = null;

	/* @var B3it_XmlBind_Opentrans21_CardAuthCode */
	private $__CardAuthCode = null;

	/* @var B3it_XmlBind_Opentrans21_CardRefNum */
	private $__CardRefNum = null;

	/* @var B3it_XmlBind_Opentrans21_CardExpirationDate */
	private $__CardExpirationDate = null;

	/* @var B3it_XmlBind_Opentrans21_CardHolderName */
	private $__CardHolderName = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CardNum
	 */
	public function getCardNum()
	{
		if($this->__CardNum == null)
		{
			$this->__CardNum = new B3it_XmlBind_Opentrans21_CardNum();
		}
	
		return $this->__CardNum;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CardNum
	 * @return B3it_XmlBind_Opentrans21_Card
	 */
	public function setCardNum($value)
	{
		$this->__CardNum = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CardAuthCode
	 */
	public function getCardAuthCode()
	{
		if($this->__CardAuthCode == null)
		{
			$this->__CardAuthCode = new B3it_XmlBind_Opentrans21_CardAuthCode();
		}
	
		return $this->__CardAuthCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CardAuthCode
	 * @return B3it_XmlBind_Opentrans21_Card
	 */
	public function setCardAuthCode($value)
	{
		$this->__CardAuthCode = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CardRefNum
	 */
	public function getCardRefNum()
	{
		if($this->__CardRefNum == null)
		{
			$this->__CardRefNum = new B3it_XmlBind_Opentrans21_CardRefNum();
		}
	
		return $this->__CardRefNum;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CardRefNum
	 * @return B3it_XmlBind_Opentrans21_Card
	 */
	public function setCardRefNum($value)
	{
		$this->__CardRefNum = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CardExpirationDate
	 */
	public function getCardExpirationDate()
	{
		if($this->__CardExpirationDate == null)
		{
			$this->__CardExpirationDate = new B3it_XmlBind_Opentrans21_CardExpirationDate();
		}
	
		return $this->__CardExpirationDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CardExpirationDate
	 * @return B3it_XmlBind_Opentrans21_Card
	 */
	public function setCardExpirationDate($value)
	{
		$this->__CardExpirationDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CardHolderName
	 */
	public function getCardHolderName()
	{
		if($this->__CardHolderName == null)
		{
			$this->__CardHolderName = new B3it_XmlBind_Opentrans21_CardHolderName();
		}
	
		return $this->__CardHolderName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CardHolderName
	 * @return B3it_XmlBind_Opentrans21_Card
	 */
	public function setCardHolderName($value)
	{
		$this->__CardHolderName = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('CARD');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CardNum != null){
			$this->__CardNum->toXml($xml);
		}
		if($this->__CardAuthCode != null){
			$this->__CardAuthCode->toXml($xml);
		}
		if($this->__CardRefNum != null){
			$this->__CardRefNum->toXml($xml);
		}
		if($this->__CardExpirationDate != null){
			$this->__CardExpirationDate->toXml($xml);
		}
		if($this->__CardHolderName != null){
			$this->__CardHolderName->toXml($xml);
		}


		return $xml;
	}

}
