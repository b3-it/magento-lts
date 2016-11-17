<?php
class B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Fname */
	private $_Fnames = array();	

	/* @var FtIdref */
	private $_FtIdref = null;	

	/* @var Ftemplate */
	private $_Ftemplate = null;	

	/* @var Fvalue */
	private $_Fvalues = array();	

	/* @var ValueIdref */
	private $_ValueIdrefs = array();	

	/* @var Variants */
	private $_Variants = null;	

	/* @var Funit */
	private $_Funit = null;	

	/* @var Forder */
	private $_Forder = null;	

	/* @var Fdescr */
	private $_Fdescrs = array();	

	/* @var FvalueDetails */
	private $_FvalueDetailss = array();	

	/* @var FvalueType */
	private $_FvalueType = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Fname[]
	 */
	public function getAllFname()
	{
		return $this->_Fnames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Fname and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Fname
	 */
	public function getFname()
	{
		$res = new B3it_XmlBind_Bmecat2005_Fname();
		$this->_Fnames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Fname[]
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFname($value)
	{
		$this->_Fname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->_FtIdref == null)
		{
			$this->_FtIdref = new B3it_XmlBind_Bmecat2005_FtIdref();
		}
		
		return $this->_FtIdref;
	}
	
	/**
	 * @param $value FtIdref
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtIdref($value)
	{
		$this->_FtIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Ftemplate
	 */
	public function getFtemplate()
	{
		if($this->_Ftemplate == null)
		{
			$this->_Ftemplate = new B3it_XmlBind_Bmecat2005_Ftemplate();
		}
		
		return $this->_Ftemplate;
	}
	
	/**
	 * @param $value Ftemplate
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtemplate($value)
	{
		$this->_Ftemplate = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueIdref($value)
	{
		$this->_ValueIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Variants
	 */
	public function getVariants()
	{
		if($this->_Variants == null)
		{
			$this->_Variants = new B3it_XmlBind_Bmecat2005_Variants();
		}
		
		return $this->_Variants;
	}
	
	/**
	 * @param $value Variants
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setVariants($value)
	{
		$this->_Variants = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Funit
	 */
	public function getFunit()
	{
		if($this->_Funit == null)
		{
			$this->_Funit = new B3it_XmlBind_Bmecat2005_Funit();
		}
		
		return $this->_Funit;
	}
	
	/**
	 * @param $value Funit
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFunit($value)
	{
		$this->_Funit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Forder
	 */
	public function getForder()
	{
		if($this->_Forder == null)
		{
			$this->_Forder = new B3it_XmlBind_Bmecat2005_Forder();
		}
		
		return $this->_Forder;
	}
	
	/**
	 * @param $value Forder
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setForder($value)
	{
		$this->_Forder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Fdescr[]
	 */
	public function getAllFdescr()
	{
		return $this->_Fdescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Fdescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Fdescr
	 */
	public function getFdescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_Fdescr();
		$this->_Fdescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Fdescr[]
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFdescr($value)
	{
		$this->_Fdescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FvalueDetails[]
	 */
	public function getAllFvalueDetails()
	{
		return $this->_FvalueDetailss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FvalueDetails and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FvalueDetails
	 */
	public function getFvalueDetails()
	{
		$res = new B3it_XmlBind_Bmecat2005_FvalueDetails();
		$this->_FvalueDetailss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FvalueDetails[]
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFvalueDetails($value)
	{
		$this->_FvalueDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FvalueType
	 */
	public function getFvalueType()
	{
		if($this->_FvalueType == null)
		{
			$this->_FvalueType = new B3it_XmlBind_Bmecat2005_FvalueType();
		}
		
		return $this->_FvalueType;
	}
	
	/**
	 * @param $value FvalueType
	 * @return B3it_XmlBind_Bmecat2005_Feature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFvalueType($value)
	{
		$this->_FvalueType = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FEATURE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Fnames != null){
			foreach($this->_Fnames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtIdref != null){
			$this->_FtIdref->toXml($xml);
		}
		if($this->_Ftemplate != null){
			$this->_Ftemplate->toXml($xml);
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
		if($this->_Variants != null){
			$this->_Variants->toXml($xml);
		}
		if($this->_Funit != null){
			$this->_Funit->toXml($xml);
		}
		if($this->_Forder != null){
			$this->_Forder->toXml($xml);
		}
		if($this->_Fdescrs != null){
			foreach($this->_Fdescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FvalueDetailss != null){
			foreach($this->_FvalueDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FvalueType != null){
			$this->_FvalueType->toXml($xml);
		}


		return $xml;
	}
}