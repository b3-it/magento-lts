<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationSystemFeatureTemplates
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplates extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplate */
	private $__ClassificationSystemFeatureTemplateA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplate and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplate
	 */
	public function getClassificationSystemFeatureTemplate()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplate();
		$this->__ClassificationSystemFeatureTemplateA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplates
	 */
	public function setClassificationSystemFeatureTemplate($value)
	{
		$this->__ClassificationSystemFeatureTemplateA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplate[]
	 */
	public function getAllClassificationSystemFeatureTemplate()
	{
		return $this->__ClassificationSystemFeatureTemplateA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM_FEATURE_TEMPLATES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM_FEATURE_TEMPLATES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ClassificationSystemFeatureTemplateA != null){
			foreach($this->__ClassificationSystemFeatureTemplateA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
