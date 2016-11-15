<?php
class B3it_XmlBind_Bmecat2005_FtDependencies extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtIdref */
	private $_FtIdrefs = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_FtIdref[]
	 */
	public function getAllFtIdref()
	{
		return $this->_FtIdrefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtIdref and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtIdref
	 */
	public function getFtIdref()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtIdref();
		$this->_FtIdrefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtIdref[]
	 * @return B3it_XmlBind_Bmecat2005_FtDependencies extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtIdref($value)
	{
		$this->_FtIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_DEPENDENCIES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtIdrefs != null){
			foreach($this->_FtIdrefs as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}