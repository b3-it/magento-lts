<?php
class B3it_XmlBind_Bmecat2005_AreaLegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Territory */
	private $_Territorys = array();	

	/* @var AreaRefs */
	private $_AreaRefs = null;	

	/* @var LegalText */
	private $_LegalTexts = array();	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->_Territorys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Territory and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Bmecat2005_Territory();
		$this->_Territorys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Territory[]
	 * @return B3it_XmlBind_Bmecat2005_AreaLegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTerritory($value)
	{
		$this->_Territory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AreaRefs
	 */
	public function getAreaRefs()
	{
		if($this->_AreaRefs == null)
		{
			$this->_AreaRefs = new B3it_XmlBind_Bmecat2005_AreaRefs();
		}
		
		return $this->_AreaRefs;
	}
	
	/**
	 * @param $value AreaRefs
	 * @return B3it_XmlBind_Bmecat2005_AreaLegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaRefs($value)
	{
		$this->_AreaRefs = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_LegalText[]
	 */
	public function getAllLegalText()
	{
		return $this->_LegalTexts;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_LegalText and add it to list
	 * @return B3it_XmlBind_Bmecat2005_LegalText
	 */
	public function getLegalText()
	{
		$res = new B3it_XmlBind_Bmecat2005_LegalText();
		$this->_LegalTexts[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value LegalText[]
	 * @return B3it_XmlBind_Bmecat2005_AreaLegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLegalText($value)
	{
		$this->_LegalText = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_AreaLegalInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AREA_LEGAL_INFO');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Territorys != null){
			foreach($this->_Territorys as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AreaRefs != null){
			$this->_AreaRefs->toXml($xml);
		}
		if($this->_LegalTexts != null){
			foreach($this->_LegalTexts as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}


		return $xml;
	}
}