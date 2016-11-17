<?php
class B3it_XmlBind_Bmecat2005_Term extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var TermId */
	private $_TermId = null;	

	/* @var TermCondition */
	private $_TermCondition = null;	

	/* @var TermExpression */
	private $_TermExpression = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_TermId
	 */
	public function getTermId()
	{
		if($this->_TermId == null)
		{
			$this->_TermId = new B3it_XmlBind_Bmecat2005_TermId();
		}
		
		return $this->_TermId;
	}
	
	/**
	 * @param $value TermId
	 * @return B3it_XmlBind_Bmecat2005_Term extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTermId($value)
	{
		$this->_TermId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TermCondition
	 */
	public function getTermCondition()
	{
		if($this->_TermCondition == null)
		{
			$this->_TermCondition = new B3it_XmlBind_Bmecat2005_TermCondition();
		}
		
		return $this->_TermCondition;
	}
	
	/**
	 * @param $value TermCondition
	 * @return B3it_XmlBind_Bmecat2005_Term extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTermCondition($value)
	{
		$this->_TermCondition = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TermExpression
	 */
	public function getTermExpression()
	{
		if($this->_TermExpression == null)
		{
			$this->_TermExpression = new B3it_XmlBind_Bmecat2005_TermExpression();
		}
		
		return $this->_TermExpression;
	}
	
	/**
	 * @param $value TermExpression
	 * @return B3it_XmlBind_Bmecat2005_Term extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTermExpression($value)
	{
		$this->_TermExpression = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('TERM');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_TermId != null){
			$this->_TermId->toXml($xml);
		}
		if($this->_TermCondition != null){
			$this->_TermCondition->toXml($xml);
		}
		if($this->_TermExpression != null){
			$this->_TermExpression->toXml($xml);
		}


		return $xml;
	}
}