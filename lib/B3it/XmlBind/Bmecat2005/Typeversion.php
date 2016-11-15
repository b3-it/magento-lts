<?php
class B3it_XmlBind_Bmecat2005_Typeversion extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Version */
	private $_Version = null;	

	/* @var VersionDate */
	private $_VersionDate = null;	

	/* @var Revision */
	private $_Revision = null;	

	/* @var RevisionDate */
	private $_RevisionDate = null;	

	/* @var OriginalDate */
	private $_OriginalDate = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Version
	 */
	public function getVersion()
	{
		if($this->_Version == null)
		{
			$this->_Version = new B3it_XmlBind_Bmecat2005_Version();
		}
		
		return $this->_Version;
	}
	
	/**
	 * @param $value Version
	 * @return B3it_XmlBind_Bmecat2005_Typeversion extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setVersion($value)
	{
		$this->_Version = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_VersionDate
	 */
	public function getVersionDate()
	{
		if($this->_VersionDate == null)
		{
			$this->_VersionDate = new B3it_XmlBind_Bmecat2005_VersionDate();
		}
		
		return $this->_VersionDate;
	}
	
	/**
	 * @param $value VersionDate
	 * @return B3it_XmlBind_Bmecat2005_Typeversion extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setVersionDate($value)
	{
		$this->_VersionDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Revision
	 */
	public function getRevision()
	{
		if($this->_Revision == null)
		{
			$this->_Revision = new B3it_XmlBind_Bmecat2005_Revision();
		}
		
		return $this->_Revision;
	}
	
	/**
	 * @param $value Revision
	 * @return B3it_XmlBind_Bmecat2005_Typeversion extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setRevision($value)
	{
		$this->_Revision = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_RevisionDate
	 */
	public function getRevisionDate()
	{
		if($this->_RevisionDate == null)
		{
			$this->_RevisionDate = new B3it_XmlBind_Bmecat2005_RevisionDate();
		}
		
		return $this->_RevisionDate;
	}
	
	/**
	 * @param $value RevisionDate
	 * @return B3it_XmlBind_Bmecat2005_Typeversion extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setRevisionDate($value)
	{
		$this->_RevisionDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_OriginalDate
	 */
	public function getOriginalDate()
	{
		if($this->_OriginalDate == null)
		{
			$this->_OriginalDate = new B3it_XmlBind_Bmecat2005_OriginalDate();
		}
		
		return $this->_OriginalDate;
	}
	
	/**
	 * @param $value OriginalDate
	 * @return B3it_XmlBind_Bmecat2005_Typeversion extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setOriginalDate($value)
	{
		$this->_OriginalDate = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_Version != null){
			$this->_Version->toXml($xml);
		}
		if($this->_VersionDate != null){
			$this->_VersionDate->toXml($xml);
		}
		if($this->_Revision != null){
			$this->_Revision->toXml($xml);
		}
		if($this->_RevisionDate != null){
			$this->_RevisionDate->toXml($xml);
		}
		if($this->_OriginalDate != null){
			$this->_OriginalDate->toXml($xml);
		}

		return $xml;
	}
}