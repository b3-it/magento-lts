<?php
class B3it_XmlBind_Bmecat12_Variants extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Variant */
	private $_Variants = array();	

	/* @var Vorder */
	private $_Vorder = null;	

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
	 * @return B3it_XmlBind_Bmecat12_Variant[]
	 */
	public function getAllVariant()
	{
		return $this->_Variants;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Variant and add it to list
	 * @return B3it_XmlBind_Bmecat12_Variant
	 */
	public function getVariant()
	{
		$res = new B3it_XmlBind_Bmecat12_Variant();
		$this->_Variants[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Variant[]
	 * @return B3it_XmlBind_Bmecat12_Variants extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setVariant($value)
	{
		$this->_Variant = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Vorder
	 */
	public function getVorder()
	{
		if($this->_Vorder == null)
		{
			$this->_Vorder = new B3it_XmlBind_Bmecat12_Vorder();
		}
		
		return $this->_Vorder;
	}
	
	/**
	 * @param $value Vorder
	 * @return B3it_XmlBind_Bmecat12_Variants extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setVorder($value)
	{
		$this->_Vorder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('VARIANTS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Variants != null){
			foreach($this->_Variants as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Vorder != null){
			$this->_Vorder->toXml($xml);
		}


		return $xml;
	}
}