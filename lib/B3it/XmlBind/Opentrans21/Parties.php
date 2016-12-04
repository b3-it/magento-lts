<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Parties
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Parties extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Party */
	private $__PartyA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Party and add it to list
	 * @return B3it_XmlBind_Opentrans21_Party
	 */
	public function getParty()
	{
		$res = new B3it_XmlBind_Opentrans21_Party();
		$this->__PartyA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Party
	 * @return B3it_XmlBind_Opentrans21_Parties
	 */
	public function setParty($value)
	{
		$this->__PartyA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Party[]
	 */
	public function getAllParty()
	{
		return $this->__PartyA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('PARTIES');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PartyA != null){
			foreach($this->__PartyA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
