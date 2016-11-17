<?php
class B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var MimeType */
	private $_MimeType = null;	

	/* @var MimeSource */
	private $_MimeSources = array();	

	/* @var MimeDescr */
	private $_MimeDescrs = array();	

	/* @var MimeAlt */
	private $_MimeAlts = array();	

	/* @var MimePurpose */
	private $_MimePurpose = null;	

	/* @var MimeOrder */
	private $_MimeOrder = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_MimeType
	 */
	public function getMimeType()
	{
		if($this->_MimeType == null)
		{
			$this->_MimeType = new B3it_XmlBind_Bmecat2005_MimeType();
		}
		
		return $this->_MimeType;
	}
	
	/**
	 * @param $value MimeType
	 * @return B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeType($value)
	{
		$this->_MimeType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeSource[]
	 */
	public function getAllMimeSource()
	{
		return $this->_MimeSources;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_MimeSource and add it to list
	 * @return B3it_XmlBind_Bmecat2005_MimeSource
	 */
	public function getMimeSource()
	{
		$res = new B3it_XmlBind_Bmecat2005_MimeSource();
		$this->_MimeSources[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value MimeSource[]
	 * @return B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeSource($value)
	{
		$this->_MimeSource = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeDescr[]
	 */
	public function getAllMimeDescr()
	{
		return $this->_MimeDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_MimeDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_MimeDescr
	 */
	public function getMimeDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_MimeDescr();
		$this->_MimeDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value MimeDescr[]
	 * @return B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeDescr($value)
	{
		$this->_MimeDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeAlt[]
	 */
	public function getAllMimeAlt()
	{
		return $this->_MimeAlts;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_MimeAlt and add it to list
	 * @return B3it_XmlBind_Bmecat2005_MimeAlt
	 */
	public function getMimeAlt()
	{
		$res = new B3it_XmlBind_Bmecat2005_MimeAlt();
		$this->_MimeAlts[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value MimeAlt[]
	 * @return B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeAlt($value)
	{
		$this->_MimeAlt = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimePurpose
	 */
	public function getMimePurpose()
	{
		if($this->_MimePurpose == null)
		{
			$this->_MimePurpose = new B3it_XmlBind_Bmecat2005_MimePurpose();
		}
		
		return $this->_MimePurpose;
	}
	
	/**
	 * @param $value MimePurpose
	 * @return B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimePurpose($value)
	{
		$this->_MimePurpose = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeOrder
	 */
	public function getMimeOrder()
	{
		if($this->_MimeOrder == null)
		{
			$this->_MimeOrder = new B3it_XmlBind_Bmecat2005_MimeOrder();
		}
		
		return $this->_MimeOrder;
	}
	
	/**
	 * @param $value MimeOrder
	 * @return B3it_XmlBind_Bmecat2005_Mime extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeOrder($value)
	{
		$this->_MimeOrder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('MIME');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_MimeType != null){
			$this->_MimeType->toXml($xml);
		}
		if($this->_MimeSources != null){
			foreach($this->_MimeSources as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimeDescrs != null){
			foreach($this->_MimeDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimeAlts != null){
			foreach($this->_MimeAlts as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MimePurpose != null){
			$this->_MimePurpose->toXml($xml);
		}
		if($this->_MimeOrder != null){
			$this->_MimeOrder->toXml($xml);
		}


		return $xml;
	}
}