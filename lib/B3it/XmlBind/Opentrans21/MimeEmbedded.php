<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	MimeEmbedded
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_MimeEmbedded extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_MimeData */
	private $__MimeData = null;

	/* @var B3it_XmlBind_Opentrans21_FileName */
	private $__FileName = null;

	/* @var B3it_XmlBind_Opentrans21_FileSize */
	private $__FileSize = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_MimeData
	 */
	public function getMimeData()
	{
		if($this->__MimeData == null)
		{
			$this->__MimeData = new B3it_XmlBind_Opentrans21_MimeData();
		}
	
		return $this->__MimeData;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MimeData
	 * @return B3it_XmlBind_Opentrans21_MimeEmbedded
	 */
	public function setMimeData($value)
	{
		$this->__MimeData = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_FileName
	 */
	public function getFileName()
	{
		if($this->__FileName == null)
		{
			$this->__FileName = new B3it_XmlBind_Opentrans21_FileName();
		}
	
		return $this->__FileName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_FileName
	 * @return B3it_XmlBind_Opentrans21_MimeEmbedded
	 */
	public function setFileName($value)
	{
		$this->__FileName = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_FileSize
	 */
	public function getFileSize()
	{
		if($this->__FileSize == null)
		{
			$this->__FileSize = new B3it_XmlBind_Opentrans21_FileSize();
		}
	
		return $this->__FileSize;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_FileSize
	 * @return B3it_XmlBind_Opentrans21_MimeEmbedded
	 */
	public function setFileSize($value)
	{
		$this->__FileSize = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('MIME_EMBEDDED');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__MimeData != null){
			$this->__MimeData->toXml($xml);
		}
		if($this->__FileName != null){
			$this->__FileName->toXml($xml);
		}
		if($this->__FileSize != null){
			$this->__FileSize->toXml($xml);
		}


		return $xml;
	}

}
