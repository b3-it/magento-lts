<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Mime
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Mime extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeType */
	private $__MimeType = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeSource */
	private $__MimeSourceA = array();

	
	/* @var B3it_XmlBind_Opentrans21_FileHashValue */
	private $__FileHashValueA = array();

	
	/* @var B3it_XmlBind_Opentrans21_MimeEmbedded */
	private $__MimeEmbeddedA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeDescr */
	private $__MimeDescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeAlt */
	private $__MimeAltA = array();

	/* @var B3it_XmlBind_Opentrans21_MimePurpose */
	private $__MimePurpose = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeOrder */
	private $__MimeOrder = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeType
	 */
	public function getMimeType()
	{
		if($this->__MimeType == null)
		{
			$this->__MimeType = new B3it_XmlBind_Opentrans21_Bmecat_MimeType();
		}
	
		return $this->__MimeType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeType
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimeType($value)
	{
		$this->__MimeType = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_MimeSource and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeSource
	 */
	public function getMimeSource()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_MimeSource();
		$this->__MimeSourceA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeSource
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimeSource($value)
	{
		$this->__MimeSourceA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeSource[]
	 */
	public function getAllMimeSource()
	{
		return $this->__MimeSourceA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_FileHashValue and add it to list
	 * @return B3it_XmlBind_Opentrans21_FileHashValue
	 */
	public function getFileHashValue()
	{
		$res = new B3it_XmlBind_Opentrans21_FileHashValue();
		$this->__FileHashValueA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_FileHashValue
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setFileHashValue($value)
	{
		$this->__FileHashValueA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_FileHashValue[]
	 */
	public function getAllFileHashValue()
	{
		return $this->__FileHashValueA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_MimeEmbedded and add it to list
	 * @return B3it_XmlBind_Opentrans21_MimeEmbedded
	 */
	public function getMimeEmbedded()
	{
		$res = new B3it_XmlBind_Opentrans21_MimeEmbedded();
		$this->__MimeEmbeddedA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MimeEmbedded
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimeEmbedded($value)
	{
		$this->__MimeEmbeddedA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_MimeEmbedded[]
	 */
	public function getAllMimeEmbedded()
	{
		return $this->__MimeEmbeddedA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_MimeDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeDescr
	 */
	public function getMimeDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_MimeDescr();
		$this->__MimeDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeDescr
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimeDescr($value)
	{
		$this->__MimeDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeDescr[]
	 */
	public function getAllMimeDescr()
	{
		return $this->__MimeDescrA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_MimeAlt and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeAlt
	 */
	public function getMimeAlt()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_MimeAlt();
		$this->__MimeAltA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeAlt
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimeAlt($value)
	{
		$this->__MimeAltA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeAlt[]
	 */
	public function getAllMimeAlt()
	{
		return $this->__MimeAltA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_MimePurpose
	 */
	public function getMimePurpose()
	{
		if($this->__MimePurpose == null)
		{
			$this->__MimePurpose = new B3it_XmlBind_Opentrans21_MimePurpose();
		}
	
		return $this->__MimePurpose;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_MimePurpose
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimePurpose($value)
	{
		$this->__MimePurpose = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeOrder
	 */
	public function getMimeOrder()
	{
		if($this->__MimeOrder == null)
		{
			$this->__MimeOrder = new B3it_XmlBind_Opentrans21_Bmecat_MimeOrder();
		}
	
		return $this->__MimeOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeOrder
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function setMimeOrder($value)
	{
		$this->__MimeOrder = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('MIME');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__MimeType != null){
			$this->__MimeType->toXml($xml);
		}
		if($this->__MimeSourceA != null){
			foreach($this->__MimeSourceA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FileHashValueA != null){
			foreach($this->__FileHashValueA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeEmbeddedA != null){
			foreach($this->__MimeEmbeddedA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeDescrA != null){
			foreach($this->__MimeDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeAltA != null){
			foreach($this->__MimeAltA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimePurpose != null){
			$this->__MimePurpose->toXml($xml);
		}
		if($this->__MimeOrder != null){
			$this->__MimeOrder->toXml($xml);
		}


		return $xml;
	}

}
