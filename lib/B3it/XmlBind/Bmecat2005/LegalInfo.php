<?php
class B3it_XmlBind_Bmecat2005_LegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AreaLegalInfo */
	private $_AreaLegalInfos = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_AreaLegalInfo[]
	 */
	public function getAllAreaLegalInfo()
	{
		return $this->_AreaLegalInfos;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AreaLegalInfo and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AreaLegalInfo
	 */
	public function getAreaLegalInfo()
	{
		$res = new B3it_XmlBind_Bmecat2005_AreaLegalInfo();
		$this->_AreaLegalInfos[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AreaLegalInfo[]
	 * @return B3it_XmlBind_Bmecat2005_LegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaLegalInfo($value)
	{
		$this->_AreaLegalInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('LEGAL_INFO');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AreaLegalInfos != null){
			foreach($this->_AreaLegalInfos as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}