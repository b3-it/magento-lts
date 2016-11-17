<?php
class B3it_XmlBind_Bmecat2005_IppDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppId */
	private $_IppId = null;	

	/* @var IppType */
	private $_IppType = null;	

	/* @var IppOperatorIdref */
	private $_IppOperatorIdref = null;	

	/* @var IppDescr */
	private $_IppDescrs = array();	

	/* @var IppOperation */
	private $_IppOperations = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppId
	 */
	public function getIppId()
	{
		if($this->_IppId == null)
		{
			$this->_IppId = new B3it_XmlBind_Bmecat2005_IppId();
		}
		
		return $this->_IppId;
	}
	
	/**
	 * @param $value IppId
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppId($value)
	{
		$this->_IppId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppType
	 */
	public function getIppType()
	{
		if($this->_IppType == null)
		{
			$this->_IppType = new B3it_XmlBind_Bmecat2005_IppType();
		}
		
		return $this->_IppType;
	}
	
	/**
	 * @param $value IppType
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppType($value)
	{
		$this->_IppType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOperatorIdref
	 */
	public function getIppOperatorIdref()
	{
		if($this->_IppOperatorIdref == null)
		{
			$this->_IppOperatorIdref = new B3it_XmlBind_Bmecat2005_IppOperatorIdref();
		}
		
		return $this->_IppOperatorIdref;
	}
	
	/**
	 * @param $value IppOperatorIdref
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOperatorIdref($value)
	{
		$this->_IppOperatorIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppDescr[]
	 */
	public function getAllIppDescr()
	{
		return $this->_IppDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppDescr
	 */
	public function getIppDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppDescr();
		$this->_IppDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppDescr[]
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppDescr($value)
	{
		$this->_IppDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOperation[]
	 */
	public function getAllIppOperation()
	{
		return $this->_IppOperations;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppOperation and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppOperation
	 */
	public function getIppOperation()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppOperation();
		$this->_IppOperations[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppOperation[]
	 * @return B3it_XmlBind_Bmecat2005_IppDefinition extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOperation($value)
	{
		$this->_IppOperation = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_DEFINITION');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppId != null){
			$this->_IppId->toXml($xml);
		}
		if($this->_IppType != null){
			$this->_IppType->toXml($xml);
		}
		if($this->_IppOperatorIdref != null){
			$this->_IppOperatorIdref->toXml($xml);
		}
		if($this->_IppDescrs != null){
			foreach($this->_IppDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_IppOperations != null){
			foreach($this->_IppOperations as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}