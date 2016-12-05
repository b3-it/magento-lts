<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Term
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Term extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_TermId */
	private $__TermId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TermCondition */
	private $__TermCondition = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TermExpression */
	private $__TermExpression = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TermId
	 */
	public function getTermId()
	{
		if($this->__TermId == null)
		{
			$this->__TermId = new B3it_XmlBind_Opentrans21_Bmecat_TermId();
		}
	
		return $this->__TermId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TermId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Term
	 */
	public function setTermId($value)
	{
		$this->__TermId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TermCondition
	 */
	public function getTermCondition()
	{
		if($this->__TermCondition == null)
		{
			$this->__TermCondition = new B3it_XmlBind_Opentrans21_Bmecat_TermCondition();
		}
	
		return $this->__TermCondition;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TermCondition
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Term
	 */
	public function setTermCondition($value)
	{
		$this->__TermCondition = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TermExpression
	 */
	public function getTermExpression()
	{
		if($this->__TermExpression == null)
		{
			$this->__TermExpression = new B3it_XmlBind_Opentrans21_Bmecat_TermExpression();
		}
	
		return $this->__TermExpression;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TermExpression
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Term
	 */
	public function setTermExpression($value)
	{
		$this->__TermExpression = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:TERM');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:TERM');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TermId != null){
			$this->__TermId->toXml($xml);
		}
		if($this->__TermCondition != null){
			$this->__TermCondition->toXml($xml);
		}
		if($this->__TermExpression != null){
			$this->__TermExpression->toXml($xml);
		}


		return $xml;
	}

}
