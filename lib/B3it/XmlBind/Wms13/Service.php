<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Service
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Service extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Service_Name */
	private $__Name = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Service_Name
	 */
	public function getName()
	{
		if($this->__Name == null)
		{
			$this->__Name = new B3it_XmlBind_Wms13_Service_Name();
		}
	
		return $this->__Name;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Service_Name
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setName($value)
	{
		$this->__Name = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('Service');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Name != null){
			$this->__Name->toXml($xml);
		}


		return $xml;
	}

}
