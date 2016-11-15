<?php
class B3it_XmlBind_Bmecat2005_ProductConfigDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ConfigStep */
	private $_ConfigSteps = array();	

	/* @var PredefinedConfigs */
	private $_PredefinedConfigs = null;	

	/* @var ConfigRules */
	private $_ConfigRules = null;	

	/* @var ConfigFormulas */
	private $_ConfigFormulas = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep[]
	 */
	public function getAllConfigStep()
	{
		return $this->_ConfigSteps;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ConfigStep and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ConfigStep
	 */
	public function getConfigStep()
	{
		$res = new B3it_XmlBind_Bmecat2005_ConfigStep();
		$this->_ConfigSteps[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ConfigStep[]
	 * @return B3it_XmlBind_Bmecat2005_ProductConfigDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigStep($value)
	{
		$this->_ConfigStep = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PredefinedConfigs
	 */
	public function getPredefinedConfigs()
	{
		if($this->_PredefinedConfigs == null)
		{
			$this->_PredefinedConfigs = new B3it_XmlBind_Bmecat2005_PredefinedConfigs();
		}
		
		return $this->_PredefinedConfigs;
	}
	
	/**
	 * @param $value PredefinedConfigs
	 * @return B3it_XmlBind_Bmecat2005_ProductConfigDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPredefinedConfigs($value)
	{
		$this->_PredefinedConfigs = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigRules
	 */
	public function getConfigRules()
	{
		if($this->_ConfigRules == null)
		{
			$this->_ConfigRules = new B3it_XmlBind_Bmecat2005_ConfigRules();
		}
		
		return $this->_ConfigRules;
	}
	
	/**
	 * @param $value ConfigRules
	 * @return B3it_XmlBind_Bmecat2005_ProductConfigDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigRules($value)
	{
		$this->_ConfigRules = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigFormulas
	 */
	public function getConfigFormulas()
	{
		if($this->_ConfigFormulas == null)
		{
			$this->_ConfigFormulas = new B3it_XmlBind_Bmecat2005_ConfigFormulas();
		}
		
		return $this->_ConfigFormulas;
	}
	
	/**
	 * @param $value ConfigFormulas
	 * @return B3it_XmlBind_Bmecat2005_ProductConfigDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigFormulas($value)
	{
		$this->_ConfigFormulas = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_CONFIG_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ConfigSteps != null){
			foreach($this->_ConfigSteps as $item){
				$item->toXml($xml);
			}
		}
		if($this->_PredefinedConfigs != null){
			$this->_PredefinedConfigs->toXml($xml);
		}
		if($this->_ConfigRules != null){
			$this->_ConfigRules->toXml($xml);
		}
		if($this->_ConfigFormulas != null){
			$this->_ConfigFormulas->toXml($xml);
		}


		return $xml;
	}
}