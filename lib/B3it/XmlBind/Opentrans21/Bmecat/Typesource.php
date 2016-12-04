<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Typesource
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Typesource extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SourceName */
	private $__SourceNameA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SourceUri */
	private $__SourceUri = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartyIdref */
	private $__PartyIdref = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_SourceName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SourceName
	 */
	public function getSourceName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_SourceName();
		$this->__SourceNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SourceName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typesource
	 */
	public function setSourceName($value)
	{
		$this->__SourceNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SourceName[]
	 */
	public function getAllSourceName()
	{
		return $this->__SourceNameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SourceUri
	 */
	public function getSourceUri()
	{
		if($this->__SourceUri == null)
		{
			$this->__SourceUri = new B3it_XmlBind_Opentrans21_Bmecat_SourceUri();
		}
	
		return $this->__SourceUri;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SourceUri
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typesource
	 */
	public function setSourceUri($value)
	{
		$this->__SourceUri = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartyIdref
	 */
	public function getPartyIdref()
	{
		if($this->__PartyIdref == null)
		{
			$this->__PartyIdref = new B3it_XmlBind_Opentrans21_Bmecat_PartyIdref();
		}
	
		return $this->__PartyIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PartyIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typesource
	 */
	public function setPartyIdref($value)
	{
		$this->__PartyIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SourceNameA != null){
			foreach($this->__SourceNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SourceUri != null){
			$this->__SourceUri->toXml($xml);
		}
		if($this->__PartyIdref != null){
			$this->__PartyIdref->toXml($xml);
		}


		return $xml;
	}

}
