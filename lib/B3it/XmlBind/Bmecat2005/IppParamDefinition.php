<?php
class B3it_XmlBind_Bmecat2005_IppParamDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppParamName */
	private $_IppParamName = null;	

	/* @var IppParamDescr */
	private $_IppParamDescrs = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppParamName
	 */
	public function getIppParamName()
	{
		if($this->_IppParamName == null)
		{
			$this->_IppParamName = new B3it_XmlBind_Bmecat2005_IppParamName();
		}
		
		return $this->_IppParamName;
	}
	
	/**
	 * @param $value IppParamName
	 * @return B3it_XmlBind_Bmecat2005_IppParamDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParamName($value)
	{
		$this->_IppParamName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppParamDescr[]
	 */
	public function getAllIppParamDescr()
	{
		return $this->_IppParamDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppParamDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppParamDescr
	 */
	public function getIppParamDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppParamDescr();
		$this->_IppParamDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppParamDescr[]
	 * @return B3it_XmlBind_Bmecat2005_IppParamDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParamDescr($value)
	{
		$this->_IppParamDescr = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_PARAM_DEFINITION');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppParamName != null){
			$this->_IppParamName->toXml($xml);
		}
		if($this->_IppParamDescrs != null){
			foreach($this->_IppParamDescrs as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}