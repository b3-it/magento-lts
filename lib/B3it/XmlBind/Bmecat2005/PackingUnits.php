<?php
class B3it_XmlBind_Bmecat2005_PackingUnits extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var PackingUnit */
	private $_PackingUnits = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit[]
	 */
	public function getAllPackingUnit()
	{
		return $this->_PackingUnits;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PackingUnit and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit
	 */
	public function getPackingUnit()
	{
		$res = new B3it_XmlBind_Bmecat2005_PackingUnit();
		$this->_PackingUnits[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PackingUnit[]
	 * @return B3it_XmlBind_Bmecat2005_PackingUnits extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPackingUnit($value)
	{
		$this->_PackingUnit = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PACKING_UNITS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PackingUnits != null){
			foreach($this->_PackingUnits as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}