<?php
class B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplates extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationGroupFeatureTemplate */
	private $_ClassificationGroupFeatureTemplates = array();	

	public function getAttribute($name){
		if(isset($this->_attributes[$name])){
			 return $this->_attributes[$name];
		}
		return null;
	}

	public function setAttribute($name,$value){
		$this->_attributes[$name] = $value;
		return $this;
	}



	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate[]
	 */
	public function getAllClassificationGroupFeatureTemplate()
	{
		return $this->_ClassificationGroupFeatureTemplates;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate
	 */
	public function getClassificationGroupFeatureTemplate()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate();
		$this->_ClassificationGroupFeatureTemplates[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroupFeatureTemplate[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplates extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupFeatureTemplate($value)
	{
		$this->_ClassificationGroupFeatureTemplate = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_GROUP_FEATURE_TEMPLATES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationGroupFeatureTemplates != null){
			foreach($this->_ClassificationGroupFeatureTemplates as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}