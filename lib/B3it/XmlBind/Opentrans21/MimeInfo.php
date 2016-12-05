<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	MimeInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_MimeInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Mime */
	private $__MimeA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Mime and add it to list
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function getMime()
	{
		$res = new B3it_XmlBind_Opentrans21_Mime();
		$this->__MimeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Mime
	 * @return B3it_XmlBind_Opentrans21_MimeInfo
	 */
	public function setMime($value)
	{
		$this->__MimeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Mime[]
	 */
	public function getAllMime()
	{
		return $this->__MimeA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('MIME_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__MimeA != null){
			foreach($this->__MimeA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
