<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationGroupFeatureTemplates
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplates extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate */
	private $__ClassificationGroupFeatureTemplateA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function getClassificationGroupFeatureTemplate()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate();
		$this->__ClassificationGroupFeatureTemplateA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplates
	 */
	public function setClassificationGroupFeatureTemplate($value)
	{
		$this->__ClassificationGroupFeatureTemplateA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate[]
	 */
	public function getAllClassificationGroupFeatureTemplate()
	{
		return $this->__ClassificationGroupFeatureTemplateA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP_FEATURE_TEMPLATES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP_FEATURE_TEMPLATES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ClassificationGroupFeatureTemplateA != null){
			foreach($this->__ClassificationGroupFeatureTemplateA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
