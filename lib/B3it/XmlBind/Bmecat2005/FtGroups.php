<?php
class B3it_XmlBind_Bmecat2005_FtGroups extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtGroup */
	private $_FtGroups = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_FtGroup[]
	 */
	public function getAllFtGroup()
	{
		return $this->_FtGroups;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtGroup and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtGroup
	 */
	public function getFtGroup()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtGroup();
		$this->_FtGroups[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtGroup[]
	 * @return B3it_XmlBind_Bmecat2005_FtGroups extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroup($value)
	{
		$this->_FtGroup = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_GROUPS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtGroups != null){
			foreach($this->_FtGroups as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}