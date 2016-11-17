<?php
class B3it_XmlBind_Bmecat2005_PredefinedConfigs extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PredefinedConfig */
	private $_PredefinedConfigs = array();	

	/* @var PredefinedConfigCoverage */
	private $_PredefinedConfigCoverage = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig[]
	 */
	public function getAllPredefinedConfig()
	{
		return $this->_PredefinedConfigs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PredefinedConfig and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfig
	 */
	public function getPredefinedConfig()
	{
		$res = new B3it_XmlBind_Bmecat2005_PredefinedConfig();
		$this->_PredefinedConfigs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PredefinedConfig[]
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigs extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfig($value)
	{
		$this->_PredefinedConfig = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigCoverage
	 */
	public function getPredefinedConfigCoverage()
	{
		if($this->_PredefinedConfigCoverage == null)
		{
			$this->_PredefinedConfigCoverage = new B3it_XmlBind_Bmecat2005_PredefinedConfigCoverage();
		}
		
		return $this->_PredefinedConfigCoverage;
	}
	
	/**
	 * @param $value PredefinedConfigCoverage
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigs extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfigCoverage($value)
	{
		$this->_PredefinedConfigCoverage = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PREDEFINED_CONFIGS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PredefinedConfigs != null){
			foreach($this->_PredefinedConfigs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PredefinedConfigCoverage != null){
			$this->_PredefinedConfigCoverage->toXml($xml);
		}


		return $xml;
	}
}