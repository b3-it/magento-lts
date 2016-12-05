<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Typeversion
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Typeversion extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Version */
	private $__Version = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_VersionDate */
	private $__VersionDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Revision */
	private $__Revision = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_RevisionDate */
	private $__RevisionDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_OriginalDate */
	private $__OriginalDate = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Version
	 */
	public function getVersion()
	{
		if($this->__Version == null)
		{
			$this->__Version = new B3it_XmlBind_Opentrans21_Bmecat_Version();
		}
	
		return $this->__Version;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Version
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeversion
	 */
	public function setVersion($value)
	{
		$this->__Version = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_VersionDate
	 */
	public function getVersionDate()
	{
		if($this->__VersionDate == null)
		{
			$this->__VersionDate = new B3it_XmlBind_Opentrans21_Bmecat_VersionDate();
		}
	
		return $this->__VersionDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_VersionDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeversion
	 */
	public function setVersionDate($value)
	{
		$this->__VersionDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Revision
	 */
	public function getRevision()
	{
		if($this->__Revision == null)
		{
			$this->__Revision = new B3it_XmlBind_Opentrans21_Bmecat_Revision();
		}
	
		return $this->__Revision;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Revision
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeversion
	 */
	public function setRevision($value)
	{
		$this->__Revision = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_RevisionDate
	 */
	public function getRevisionDate()
	{
		if($this->__RevisionDate == null)
		{
			$this->__RevisionDate = new B3it_XmlBind_Opentrans21_Bmecat_RevisionDate();
		}
	
		return $this->__RevisionDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_RevisionDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeversion
	 */
	public function setRevisionDate($value)
	{
		$this->__RevisionDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_OriginalDate
	 */
	public function getOriginalDate()
	{
		if($this->__OriginalDate == null)
		{
			$this->__OriginalDate = new B3it_XmlBind_Opentrans21_Bmecat_OriginalDate();
		}
	
		return $this->__OriginalDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_OriginalDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeversion
	 */
	public function setOriginalDate($value)
	{
		$this->__OriginalDate = $value;
		return $this;
	}





	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Version != null){
			$this->__Version->toXml($xml);
		}
		if($this->__VersionDate != null){
			$this->__VersionDate->toXml($xml);
		}
		if($this->__Revision != null){
			$this->__Revision->toXml($xml);
		}
		if($this->__RevisionDate != null){
			$this->__RevisionDate->toXml($xml);
		}
		if($this->__OriginalDate != null){
			$this->__OriginalDate->toXml($xml);
		}


		return $xml;
	}

}
