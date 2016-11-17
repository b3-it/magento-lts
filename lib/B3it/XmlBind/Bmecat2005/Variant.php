<?php
class B3it_XmlBind_Bmecat2005_Variant extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Fvalue */
	private $_Fvalues = array();	

	/* @var ValueIdref */
	private $_ValueIdrefs = array();	

	/* @var SupplierAidSupplement */
	private $_SupplierAidSupplement = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Fvalue[]
	 */
	public function getAllFvalue()
	{
		return $this->_Fvalues;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Fvalue and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Fvalue
	 */
	public function getFvalue()
	{
		$res = new B3it_XmlBind_Bmecat2005_Fvalue();
		$this->_Fvalues[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Fvalue[]
	 * @return B3it_XmlBind_Bmecat2005_Variant extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFvalue($value)
	{
		$this->_Fvalue = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValueIdref[]
	 */
	public function getAllValueIdref()
	{
		return $this->_ValueIdrefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ValueIdref and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ValueIdref
	 */
	public function getValueIdref()
	{
		$res = new B3it_XmlBind_Bmecat2005_ValueIdref();
		$this->_ValueIdrefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ValueIdref[]
	 * @return B3it_XmlBind_Bmecat2005_Variant extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueIdref($value)
	{
		$this->_ValueIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierAidSupplement
	 */
	public function getSupplierAidSupplement()
	{
		if($this->_SupplierAidSupplement == null)
		{
			$this->_SupplierAidSupplement = new B3it_XmlBind_Bmecat2005_SupplierAidSupplement();
		}
		
		return $this->_SupplierAidSupplement;
	}
	
	/**
	 * @param $value SupplierAidSupplement
	 * @return B3it_XmlBind_Bmecat2005_Variant extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierAidSupplement($value)
	{
		$this->_SupplierAidSupplement = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('VARIANT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Fvalues != null){
			foreach($this->_Fvalues as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ValueIdrefs != null){
			foreach($this->_ValueIdrefs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_SupplierAidSupplement != null){
			$this->_SupplierAidSupplement->toXml($xml);
		}


		return $xml;
	}
}