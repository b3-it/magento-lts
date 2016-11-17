<?php
class B3it_XmlBind_Bmecat2005_Typesource extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SourceName */
	private $_SourceNames = array();	

	/* @var SourceUri */
	private $_SourceUri = null;	

	/* @var PartyIdref */
	private $_PartyIdref = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_SourceName[]
	 */
	public function getAllSourceName()
	{
		return $this->_SourceNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_SourceName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_SourceName
	 */
	public function getSourceName()
	{
		$res = new B3it_XmlBind_Bmecat2005_SourceName();
		$this->_SourceNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value SourceName[]
	 * @return B3it_XmlBind_Bmecat2005_Typesource extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSourceName($value)
	{
		$this->_SourceName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SourceUri
	 */
	public function getSourceUri()
	{
		if($this->_SourceUri == null)
		{
			$this->_SourceUri = new B3it_XmlBind_Bmecat2005_SourceUri();
		}
		
		return $this->_SourceUri;
	}
	
	/**
	 * @param $value SourceUri
	 * @return B3it_XmlBind_Bmecat2005_Typesource extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSourceUri($value)
	{
		$this->_SourceUri = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PartyIdref
	 */
	public function getPartyIdref()
	{
		if($this->_PartyIdref == null)
		{
			$this->_PartyIdref = new B3it_XmlBind_Bmecat2005_PartyIdref();
		}
		
		return $this->_PartyIdref;
	}
	
	/**
	 * @param $value PartyIdref
	 * @return B3it_XmlBind_Bmecat2005_Typesource extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPartyIdref($value)
	{
		$this->_PartyIdref = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_SourceNames != null){
			foreach($this->_SourceNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_SourceUri != null){
			$this->_SourceUri->toXml($xml);
		}
		if($this->_PartyIdref != null){
			$this->_PartyIdref->toXml($xml);
		}

		return $xml;
	}
}