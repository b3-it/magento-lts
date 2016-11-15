<?php
class B3it_XmlBind_Bmecat2005_IppAuthentificationInfo extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Authentification */
	private $_Authentifications = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Authentification[]
	 */
	public function getAllAuthentification()
	{
		return $this->_Authentifications;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Authentification and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Authentification
	 */
	public function getAuthentification()
	{
		$res = new B3it_XmlBind_Bmecat2005_Authentification();
		$this->_Authentifications[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Authentification[]
	 * @return B3it_XmlBind_Bmecat2005_IppAuthentificationInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAuthentification($value)
	{
		$this->_Authentification = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_AUTHENTIFICATION_INFO');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Authentifications != null){
			foreach($this->_Authentifications as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}