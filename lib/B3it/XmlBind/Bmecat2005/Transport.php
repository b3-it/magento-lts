<?php
class B3it_XmlBind_Bmecat2005_Transport extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Incoterm */
	private $_Incoterm = null;	

	/* @var Location */
	private $_Location = null;	

	/* @var TransportRemark */
	private $_TransportRemarks = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_Incoterm
	 */
	public function getIncoterm()
	{
		if($this->_Incoterm == null)
		{
			$this->_Incoterm = new B3it_XmlBind_Bmecat2005_Incoterm();
		}
		
		return $this->_Incoterm;
	}
	
	/**
	 * @param $value Incoterm
	 * @return B3it_XmlBind_Bmecat2005_Transport extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIncoterm($value)
	{
		$this->_Incoterm = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Location
	 */
	public function getLocation()
	{
		if($this->_Location == null)
		{
			$this->_Location = new B3it_XmlBind_Bmecat2005_Location();
		}
		
		return $this->_Location;
	}
	
	/**
	 * @param $value Location
	 * @return B3it_XmlBind_Bmecat2005_Transport extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLocation($value)
	{
		$this->_Location = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TransportRemark[]
	 */
	public function getAllTransportRemark()
	{
		return $this->_TransportRemarks;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TransportRemark and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TransportRemark
	 */
	public function getTransportRemark()
	{
		$res = new B3it_XmlBind_Bmecat2005_TransportRemark();
		$this->_TransportRemarks[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value TransportRemark[]
	 * @return B3it_XmlBind_Bmecat2005_Transport extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTransportRemark($value)
	{
		$this->_TransportRemark = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('TRANSPORT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Incoterm != null){
			$this->_Incoterm->toXml($xml);
		}
		if($this->_Location != null){
			$this->_Location->toXml($xml);
		}
		if($this->_TransportRemarks != null){
			foreach($this->_TransportRemarks as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}