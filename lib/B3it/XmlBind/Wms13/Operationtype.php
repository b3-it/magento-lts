<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Operationtype
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Operationtype extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Wms13_Format */
	private $__FormatA = array();

	
	/* @var B3it_XmlBind_Wms13_Dcptype */
	private $__DcptypeA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Wms13_Format and add it to list
	 * @return B3it_XmlBind_Wms13_Format
	 */
	public function getFormat()
	{
		$res = new B3it_XmlBind_Wms13_Format();
		$this->__FormatA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Format
	 * @return B3it_XmlBind_Wms13_Operationtype
	 */
	public function setFormat($value)
	{
		$this->__FormatA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Format[]
	 */
	public function getAllFormat()
	{
		return $this->__FormatA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Dcptype and add it to list
	 * @return B3it_XmlBind_Wms13_Dcptype
	 */
	public function getDcptype()
	{
		$res = new B3it_XmlBind_Wms13_Dcptype();
		$this->__DcptypeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Dcptype
	 * @return B3it_XmlBind_Wms13_Operationtype
	 */
	public function setDcptype($value)
	{
		$this->__DcptypeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Dcptype[]
	 */
	public function getAllDcptype()
	{
		return $this->__DcptypeA;
	}







	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FormatA != null){
			foreach($this->__FormatA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DcptypeA != null){
			foreach($this->__DcptypeA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
