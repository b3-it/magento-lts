<?php
class B3it_XmlBind_Bmecat2005_FtFacets extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtFacet */
	private $_FtFacets = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_FtFacet[]
	 */
	public function getAllFtFacet()
	{
		return $this->_FtFacets;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtFacet and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtFacet
	 */
	public function getFtFacet()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtFacet();
		$this->_FtFacets[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtFacet[]
	 * @return B3it_XmlBind_Bmecat2005_FtFacets extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtFacet($value)
	{
		$this->_FtFacet = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_FACETS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtFacets != null){
			foreach($this->_FtFacets as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}