<?php
class B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplates extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationSystemFeatureTemplate */
	private $_ClassificationSystemFeatureTemplates = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate[]
	 */
	public function getAllClassificationSystemFeatureTemplate()
	{
		return $this->_ClassificationSystemFeatureTemplates;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate
	 */
	public function getClassificationSystemFeatureTemplate()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate();
		$this->_ClassificationSystemFeatureTemplates[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationSystemFeatureTemplate[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplates extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemFeatureTemplate($value)
	{
		$this->_ClassificationSystemFeatureTemplate = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_SYSTEM_FEATURE_TEMPLATES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationSystemFeatureTemplates != null){
			foreach($this->_ClassificationSystemFeatureTemplates as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}