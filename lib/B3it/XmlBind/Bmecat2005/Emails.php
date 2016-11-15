<?php
class B3it_XmlBind_Bmecat2005_Emails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Email */
	private $_Email = null;	

	/* @var PublicKey */
	private $_PublicKeys = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Email
	 */
	public function getEmail()
	{
		if($this->_Email == null)
		{
			$this->_Email = new B3it_XmlBind_Bmecat2005_Email();
		}
		
		return $this->_Email;
	}
	
	/**
	 * @param $value Email
	 * @return B3it_XmlBind_Bmecat2005_Emails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setEmail($value)
	{
		$this->_Email = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PublicKey[]
	 */
	public function getAllPublicKey()
	{
		return $this->_PublicKeys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PublicKey and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PublicKey
	 */
	public function getPublicKey()
	{
		$res = new B3it_XmlBind_Bmecat2005_PublicKey();
		$this->_PublicKeys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PublicKey[]
	 * @return B3it_XmlBind_Bmecat2005_Emails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPublicKey($value)
	{
		$this->_PublicKey = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('EMAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Email != null){
			$this->_Email->toXml($xml);
		}
		if($this->_PublicKeys != null){
			foreach($this->_PublicKeys as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}