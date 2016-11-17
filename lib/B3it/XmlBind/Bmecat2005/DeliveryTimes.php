<?php
class B3it_XmlBind_Bmecat2005_DeliveryTimes extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Territory */
	private $_Territorys = array();	

	/* @var AreaRefs */
	private $_AreaRefs = null;	

	/* @var TimeSpan */
	private $_TimeSpans = array();	

	/* @var Leadtime */
	private $_Leadtime = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAreaRefs($value)
	{
		$this->_AreaRefs = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TimeSpan[]
	 */
	public function getAllTimeSpan()
	{
		return $this->_TimeSpans;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_TimeSpan and add it to list
	 * @return B3it_XmlBind_Bmecat2005_TimeSpan
	 */
	public function getTimeSpan()
	{
		$res = new B3it_XmlBind_Bmecat2005_TimeSpan();
		$this->_TimeSpans[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value TimeSpan[]
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTimeSpan($value)
	{
		$this->_TimeSpan = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Leadtime
	 */
	public function getLeadtime()
	{
		if($this->_Leadtime == null)
		{
			$this->_Leadtime = new B3it_XmlBind_Bmecat2005_Leadtime();
		}
		
		return $this->_Leadtime;
	}
	
	/**
	 * @param $value Leadtime
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLeadtime($value)
	{
		$this->_Leadtime = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('DELIVERY_TIMES');
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
		if($this->_TimeSpans != null){
			foreach($this->_TimeSpans as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Leadtime != null){
			$this->_Leadtime->toXml($xml);
		}


		return $xml;
	}
}