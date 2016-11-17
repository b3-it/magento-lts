<?php
class B3it_XmlBind_Bmecat2005_AccountingInfo extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var CostCategoryId */
	private $_CostCategoryId = null;	

	/* @var CostType */
	private $_CostType = null;	

	/* @var CostAccount */
	private $_CostAccount = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_CostCategoryId
	 */
	public function getCostCategoryId()
	{
		if($this->_CostCategoryId == null)
		{
			$this->_CostCategoryId = new B3it_XmlBind_Bmecat2005_CostCategoryId();
		}
		
		return $this->_CostCategoryId;
	}
	
	/**
	 * @param $value CostCategoryId
	 * @return B3it_XmlBind_Bmecat2005_AccountingInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCostCategoryId($value)
	{
		$this->_CostCategoryId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CostType
	 */
	public function getCostType()
	{
		if($this->_CostType == null)
		{
			$this->_CostType = new B3it_XmlBind_Bmecat2005_CostType();
		}
		
		return $this->_CostType;
	}
	
	/**
	 * @param $value CostType
	 * @return B3it_XmlBind_Bmecat2005_AccountingInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCostType($value)
	{
		$this->_CostType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CostAccount
	 */
	public function getCostAccount()
	{
		if($this->_CostAccount == null)
		{
			$this->_CostAccount = new B3it_XmlBind_Bmecat2005_CostAccount();
		}
		
		return $this->_CostAccount;
	}
	
	/**
	 * @param $value CostAccount
	 * @return B3it_XmlBind_Bmecat2005_AccountingInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCostAccount($value)
	{
		$this->_CostAccount = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ACCOUNTING_INFO');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_CostCategoryId != null){
			$this->_CostCategoryId->toXml($xml);
		}
		if($this->_CostType != null){
			$this->_CostType->toXml($xml);
		}
		if($this->_CostAccount != null){
			$this->_CostAccount->toXml($xml);
		}


		return $xml;
	}
}