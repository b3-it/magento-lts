<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	PackageInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_PackageInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Package */
	private $__PackageA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Package and add it to list
	 * @return B3it_XmlBind_Opentrans21_Package
	 */
	public function getPackage()
	{
		$res = new B3it_XmlBind_Opentrans21_Package();
		$this->__PackageA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Package
	 * @return B3it_XmlBind_Opentrans21_PackageInfo
	 */
	public function setPackage($value)
	{
		$this->__PackageA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Package[]
	 */
	public function getAllPackage()
	{
		return $this->__PackageA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('PACKAGE_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PackageA != null){
			foreach($this->__PackageA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
