<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppParamDefinition
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParamName */
	private $__IppParamName = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParamDescr */
	private $__IppParamDescrA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamName
	 */
	public function getIppParamName()
	{
		if($this->__IppParamName == null)
		{
			$this->__IppParamName = new B3it_XmlBind_Opentrans21_Bmecat_IppParamName();
		}
	
		return $this->__IppParamName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParamName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition
	 */
	public function setIppParamName($value)
	{
		$this->__IppParamName = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppParamDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDescr
	 */
	public function getIppParamDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppParamDescr();
		$this->__IppParamDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParamDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition
	 */
	public function setIppParamDescr($value)
	{
		$this->__IppParamDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDescr[]
	 */
	public function getAllIppParamDescr()
	{
		return $this->__IppParamDescrA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PARAM_DEFINITION');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PARAM_DEFINITION');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppParamName != null){
			$this->__IppParamName->toXml($xml);
		}
		if($this->__IppParamDescrA != null){
			foreach($this->__IppParamDescrA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
