<?php
class B3it_XmlBind_Bmecat2005_FtValues extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtValue */
	private $_FtValues = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_FtValue[]
	 */
	public function getAllFtValue()
	{
		return $this->_FtValues;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtValue and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtValue
	 */
	public function getFtValue()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtValue();
		$this->_FtValues[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtValue[]
	 * @return B3it_XmlBind_Bmecat2005_FtValues extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtValue($value)
	{
		$this->_FtValue = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_VALUES');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtValues != null){
			foreach($this->_FtValues as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}