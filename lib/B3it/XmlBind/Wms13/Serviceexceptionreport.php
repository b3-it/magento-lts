<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Serviceexceptionreport
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Serviceexceptionreport extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Wms13_Serviceexceptionreport_Serviceexception */
	private $__ServiceexceptionA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Wms13_Serviceexceptionreport_Serviceexception and add it to list
	 * @return B3it_XmlBind_Wms13_Serviceexceptionreport_Serviceexception
	 */
	public function getServiceexception()
	{
		$res = new B3it_XmlBind_Wms13_Serviceexceptionreport_Serviceexception();
		$this->__ServiceexceptionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Serviceexceptionreport_Serviceexception
	 * @return B3it_XmlBind_Wms13_Serviceexceptionreport
	 */
	public function setServiceexception($value)
	{
		$this->__ServiceexceptionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Serviceexceptionreport_Serviceexception[]
	 */
	public function getAllServiceexception()
	{
		return $this->__ServiceexceptionA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('ServiceExceptionReport');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ServiceexceptionA != null){
			foreach($this->__ServiceexceptionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
