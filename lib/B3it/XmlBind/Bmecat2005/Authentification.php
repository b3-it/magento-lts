<?php
class B3it_XmlBind_Bmecat2005_Authentification extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Login */
	private $_Login = null;	

	/* @var Password */
	private $_Password = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Login
	 */
	public function getLogin()
	{
		if($this->_Login == null)
		{
			$this->_Login = new B3it_XmlBind_Bmecat2005_Login();
		}
		
		return $this->_Login;
	}
	
	/**
	 * @param $value Login
	 * @return B3it_XmlBind_Bmecat2005_Authentification extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLogin($value)
	{
		$this->_Login = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Password
	 */
	public function getPassword()
	{
		if($this->_Password == null)
		{
			$this->_Password = new B3it_XmlBind_Bmecat2005_Password();
		}
		
		return $this->_Password;
	}
	
	/**
	 * @param $value Password
	 * @return B3it_XmlBind_Bmecat2005_Authentification extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPassword($value)
	{
		$this->_Password = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AUTHENTIFICATION');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Login != null){
			$this->_Login->toXml($xml);
		}
		if($this->_Password != null){
			$this->_Password->toXml($xml);
		}


		return $xml;
	}
}