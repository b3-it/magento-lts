<?php
class B3it_XmlBind_Bmecat12_MimeInfo extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Mime */
	private $_Mimes = array();	

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
	 * @return B3it_XmlBind_Bmecat12_Mime[]
	 */
	public function getAllMime()
	{
		return $this->_Mimes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Mime and add it to list
	 * @return B3it_XmlBind_Bmecat12_Mime
	 */
	public function getMime()
	{
		$res = new B3it_XmlBind_Bmecat12_Mime();
		$this->_Mimes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Mime[]
	 * @return B3it_XmlBind_Bmecat12_MimeInfo extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMime($value)
	{
		$this->_Mime = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('MIME_INFO');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Mimes != null){
			foreach($this->_Mimes as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}