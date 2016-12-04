<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_AccountingInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CostCategoryId */
	private $__CostCategoryId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CostType */
	private $__CostType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CostAccount */
	private $__CostAccount = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CostCategoryId
	 */
	public function getCostCategoryId()
	{
		if($this->__CostCategoryId == null)
		{
			$this->__CostCategoryId = new B3it_XmlBind_Opentrans21_Bmecat_CostCategoryId();
		}
	
		return $this->__CostCategoryId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CostCategoryId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 */
	public function setCostCategoryId($value)
	{
		$this->__CostCategoryId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CostType
	 */
	public function getCostType()
	{
		if($this->__CostType == null)
		{
			$this->__CostType = new B3it_XmlBind_Opentrans21_Bmecat_CostType();
		}
	
		return $this->__CostType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CostType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 */
	public function setCostType($value)
	{
		$this->__CostType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CostAccount
	 */
	public function getCostAccount()
	{
		if($this->__CostAccount == null)
		{
			$this->__CostAccount = new B3it_XmlBind_Opentrans21_Bmecat_CostAccount();
		}
	
		return $this->__CostAccount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CostAccount
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AccountingInfo
	 */
	public function setCostAccount($value)
	{
		$this->__CostAccount = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ACCOUNTING_INFO');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ACCOUNTING_INFO');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CostCategoryId != null){
			$this->__CostCategoryId->toXml($xml);
		}
		if($this->__CostType != null){
			$this->__CostType->toXml($xml);
		}
		if($this->__CostAccount != null){
			$this->__CostAccount->toXml($xml);
		}


		return $xml;
	}

}
