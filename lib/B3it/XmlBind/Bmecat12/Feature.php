<?php
class B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Fname */
	private $_Fname = null;	

	/* @var Variants */
	private $_Variants = null;	

	/* @var Fvalue */
	private $_Fvalues = array();	

	/* @var Funit */
	private $_Funit = null;	

	/* @var Forder */
	private $_Forder = null;	

	/* @var Fdescr */
	private $_Fdescr = null;	

	/* @var FvalueDetails */
	private $_FvalueDetails = null;	

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
	 * @return B3it_XmlBind_Bmecat12_Fname
	 */
	public function getFname()
	{
		if($this->_Fname == null)
		{
			$this->_Fname = new B3it_XmlBind_Bmecat12_Fname();
		}
		
		return $this->_Fname;
	}
	
	/**
	 * @param $value Fname
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFname($value)
	{
		$this->_Fname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Variants
	 */
	public function getVariants()
	{
		if($this->_Variants == null)
		{
			$this->_Variants = new B3it_XmlBind_Bmecat12_Variants();
		}
		
		return $this->_Variants;
	}
	
	/**
	 * @param $value Variants
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setVariants($value)
	{
		$this->_Variants = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Fvalue[]
	 */
	public function getAllFvalue()
	{
		return $this->_Fvalues;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Fvalue and add it to list
	 * @return B3it_XmlBind_Bmecat12_Fvalue
	 */
	public function getFvalue()
	{
		$res = new B3it_XmlBind_Bmecat12_Fvalue();
		$this->_Fvalues[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Fvalue[]
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFvalue($value)
	{
		$this->_Fvalue = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Funit
	 */
	public function getFunit()
	{
		if($this->_Funit == null)
		{
			$this->_Funit = new B3it_XmlBind_Bmecat12_Funit();
		}
		
		return $this->_Funit;
	}
	
	/**
	 * @param $value Funit
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFunit($value)
	{
		$this->_Funit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Forder
	 */
	public function getForder()
	{
		if($this->_Forder == null)
		{
			$this->_Forder = new B3it_XmlBind_Bmecat12_Forder();
		}
		
		return $this->_Forder;
	}
	
	/**
	 * @param $value Forder
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setForder($value)
	{
		$this->_Forder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Fdescr
	 */
	public function getFdescr()
	{
		if($this->_Fdescr == null)
		{
			$this->_Fdescr = new B3it_XmlBind_Bmecat12_Fdescr();
		}
		
		return $this->_Fdescr;
	}
	
	/**
	 * @param $value Fdescr
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFdescr($value)
	{
		$this->_Fdescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FvalueDetails
	 */
	public function getFvalueDetails()
	{
		if($this->_FvalueDetails == null)
		{
			$this->_FvalueDetails = new B3it_XmlBind_Bmecat12_FvalueDetails();
		}
		
		return $this->_FvalueDetails;
	}
	
	/**
	 * @param $value FvalueDetails
	 * @return B3it_XmlBind_Bmecat12_Feature extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFvalueDetails($value)
	{
		$this->_FvalueDetails = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FEATURE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Fname != null){
			$this->_Fname->toXml($xml);
		}
		if($this->_Variants != null){
			$this->_Variants->toXml($xml);
		}
		if($this->_Fvalues != null){
			foreach($this->_Fvalues as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Funit != null){
			$this->_Funit->toXml($xml);
		}
		if($this->_Forder != null){
			$this->_Forder->toXml($xml);
		}
		if($this->_Fdescr != null){
			$this->_Fdescr->toXml($xml);
		}
		if($this->_FvalueDetails != null){
			$this->_FvalueDetails->toXml($xml);
		}


		return $xml;
	}
}