<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DocexchangePartiesReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DocexchangePartiesReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DocumentIssuerIdref */
	private $__DocumentIssuerIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_DocumentRecipientIdref */
	private $__DocumentRecipientIdrefA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DocumentIssuerIdref
	 */
	public function getDocumentIssuerIdref()
	{
		if($this->__DocumentIssuerIdref == null)
		{
			$this->__DocumentIssuerIdref = new B3it_XmlBind_Opentrans21_DocumentIssuerIdref();
		}
	
		return $this->__DocumentIssuerIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DocumentIssuerIdref
	 * @return B3it_XmlBind_Opentrans21_DocexchangePartiesReference
	 */
	public function setDocumentIssuerIdref($value)
	{
		$this->__DocumentIssuerIdref = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_DocumentRecipientIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_DocumentRecipientIdref
	 */
	public function getDocumentRecipientIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_DocumentRecipientIdref();
		$this->__DocumentRecipientIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DocumentRecipientIdref
	 * @return B3it_XmlBind_Opentrans21_DocexchangePartiesReference
	 */
	public function setDocumentRecipientIdref($value)
	{
		$this->__DocumentRecipientIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DocumentRecipientIdref[]
	 */
	public function getAllDocumentRecipientIdref()
	{
		return $this->__DocumentRecipientIdrefA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('DOCEXCHANGE_PARTIES_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DocumentIssuerIdref != null){
			$this->__DocumentIssuerIdref->toXml($xml);
		}
		if($this->__DocumentRecipientIdrefA != null){
			foreach($this->__DocumentRecipientIdrefA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
