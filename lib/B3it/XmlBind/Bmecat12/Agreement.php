<?php
class B3it_XmlBind_Bmecat12_Agreement extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var AgreementId */
	private $_AgreementId = null;	

	/* @var Agreement_Datetime */
	private $_Datetimes = array();	

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
	 * @return B3it_XmlBind_Bmecat12_AgreementId
	 */
	public function getAgreementId()
	{
		if($this->_AgreementId == null)
		{
			$this->_AgreementId = new B3it_XmlBind_Bmecat12_AgreementId();
		}
		
		return $this->_AgreementId;
	}
	
	/**
	 * @param $value AgreementId
	 * @return B3it_XmlBind_Bmecat12_Agreement extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAgreementId($value)
	{
		$this->_AgreementId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Agreement_Datetime[]
	 */
	public function getAllDatetime()
	{
		return $this->_Datetimes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Agreement_Datetime and add it to list
	 * @return B3it_XmlBind_Bmecat12_Agreement_Datetime
	 */
	public function getDatetime()
	{
		$res = new B3it_XmlBind_Bmecat12_Agreement_Datetime();
		$this->_Datetimes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Datetime[]
	 * @return B3it_XmlBind_Bmecat12_Agreement extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDatetime($value)
	{
		$this->_Datetime = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AGREEMENT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AgreementId != null){
			$this->_AgreementId->toXml($xml);
		}
		if($this->_Datetimes != null){
			foreach($this->_Datetimes as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}