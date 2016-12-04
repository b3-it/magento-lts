<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Fref
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Fref extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName */
	private $__ReferenceFeatureSystemName = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtIdref */
	private $__FtIdref = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName
	 */
	public function getReferenceFeatureSystemName()
	{
		if($this->__ReferenceFeatureSystemName == null)
		{
			$this->__ReferenceFeatureSystemName = new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName();
		}
	
		return $this->__ReferenceFeatureSystemName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fref
	 */
	public function setReferenceFeatureSystemName($value)
	{
		$this->__ReferenceFeatureSystemName = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->__FtIdref == null)
		{
			$this->__FtIdref = new B3it_XmlBind_Opentrans21_Bmecat_FtIdref();
		}
	
		return $this->__FtIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fref
	 */
	public function setFtIdref($value)
	{
		$this->__FtIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FREF');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FREF');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ReferenceFeatureSystemName != null){
			$this->__ReferenceFeatureSystemName->toXml($xml);
		}
		if($this->__FtIdref != null){
			$this->__FtIdref->toXml($xml);
		}


		return $xml;
	}

}
