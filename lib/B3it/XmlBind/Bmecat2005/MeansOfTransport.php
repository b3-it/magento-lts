<?php
class B3it_XmlBind_Bmecat2005_MeansOfTransport extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var MeansOfTransportId */
	private $_MeansOfTransportId = null;	

	/* @var MeansOfTransportName */
	private $_MeansOfTransportNames = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransportId
	 */
	public function getMeansOfTransportId()
	{
		if($this->_MeansOfTransportId == null)
		{
			$this->_MeansOfTransportId = new B3it_XmlBind_Bmecat2005_MeansOfTransportId();
		}
		
		return $this->_MeansOfTransportId;
	}
	
	/**
	 * @param $value MeansOfTransportId
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransport extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMeansOfTransportId($value)
	{
		$this->_MeansOfTransportId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransportName[]
	 */
	public function getAllMeansOfTransportName()
	{
		return $this->_MeansOfTransportNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_MeansOfTransportName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransportName
	 */
	public function getMeansOfTransportName()
	{
		$res = new B3it_XmlBind_Bmecat2005_MeansOfTransportName();
		$this->_MeansOfTransportNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value MeansOfTransportName[]
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransport extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMeansOfTransportName($value)
	{
		$this->_MeansOfTransportName = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('MEANS_OF_TRANSPORT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_MeansOfTransportId != null){
			$this->_MeansOfTransportId->toXml($xml);
		}
		if($this->_MeansOfTransportNames != null){
			foreach($this->_MeansOfTransportNames as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}