<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppDefinition
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppDefinition extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppId */
	private $__IppId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppType */
	private $__IppType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOperatorIdref */
	private $__IppOperatorIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppDescr */
	private $__IppDescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppOperation */
	private $__IppOperationA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppId
	 */
	public function getIppId()
	{
		if($this->__IppId == null)
		{
			$this->__IppId = new B3it_XmlBind_Opentrans21_Bmecat_IppId();
		}
	
		return $this->__IppId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 */
	public function setIppId($value)
	{
		$this->__IppId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppType
	 */
	public function getIppType()
	{
		if($this->__IppType == null)
		{
			$this->__IppType = new B3it_XmlBind_Opentrans21_Bmecat_IppType();
		}
	
		return $this->__IppType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 */
	public function setIppType($value)
	{
		$this->__IppType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperatorIdref
	 */
	public function getIppOperatorIdref()
	{
		if($this->__IppOperatorIdref == null)
		{
			$this->__IppOperatorIdref = new B3it_XmlBind_Opentrans21_Bmecat_IppOperatorIdref();
		}
	
		return $this->__IppOperatorIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOperatorIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 */
	public function setIppOperatorIdref($value)
	{
		$this->__IppOperatorIdref = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDescr
	 */
	public function getIppDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppDescr();
		$this->__IppDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 */
	public function setIppDescr($value)
	{
		$this->__IppDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDescr[]
	 */
	public function getAllIppDescr()
	{
		return $this->__IppDescrA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppOperation and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 */
	public function getIppOperation()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppOperation();
		$this->__IppOperationA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppOperation
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 */
	public function setIppOperation($value)
	{
		$this->__IppOperationA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppOperation[]
	 */
	public function getAllIppOperation()
	{
		return $this->__IppOperationA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_DEFINITION');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_DEFINITION');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppId != null){
			$this->__IppId->toXml($xml);
		}
		if($this->__IppType != null){
			$this->__IppType->toXml($xml);
		}
		if($this->__IppOperatorIdref != null){
			$this->__IppOperatorIdref->toXml($xml);
		}
		if($this->__IppDescrA != null){
			foreach($this->__IppDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__IppOperationA != null){
			foreach($this->__IppOperationA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
