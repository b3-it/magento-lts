<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Feature
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Feature extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fname */
	private $__FnameA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtIdref */
	private $__FtIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Ftemplate */
	private $__Ftemplate = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fvalue */
	private $__FvalueA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueIdref */
	private $__ValueIdrefA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Funit */
	private $__Funit = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Forder */
	private $__Forder = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fdescr */
	private $__FdescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FvalueDetails */
	private $__FvalueDetailsA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FvalueType */
	private $__FvalueType = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Fname and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fname
	 */
	public function getFname()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Fname();
		$this->__FnameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fname
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFname($value)
	{
		$this->__FnameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fname[]
	 */
	public function getAllFname()
	{
		return $this->__FnameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->__FtIdref == null)
		{
			$this->__FtIdref = new B3it_XmlBind_Opentrans21_Bmecat_FtIdref();
		}
	
		return $this->__FtIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFtIdref($value)
	{
		$this->__FtIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ftemplate
	 */
	public function getFtemplate()
	{
		if($this->__Ftemplate == null)
		{
			$this->__Ftemplate = new B3it_XmlBind_Opentrans21_Bmecat_Ftemplate();
		}
	
		return $this->__Ftemplate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Ftemplate
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFtemplate($value)
	{
		$this->__Ftemplate = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Fvalue and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fvalue
	 */
	public function getFvalue()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Fvalue();
		$this->__FvalueA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fvalue
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFvalue($value)
	{
		$this->__FvalueA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fvalue[]
	 */
	public function getAllFvalue()
	{
		return $this->__FvalueA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ValueIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueIdref
	 */
	public function getValueIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ValueIdref();
		$this->__ValueIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueIdref
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setValueIdref($value)
	{
		$this->__ValueIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueIdref[]
	 */
	public function getAllValueIdref()
	{
		return $this->__ValueIdrefA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Funit
	 */
	public function getFunit()
	{
		if($this->__Funit == null)
		{
			$this->__Funit = new B3it_XmlBind_Opentrans21_Bmecat_Funit();
		}
	
		return $this->__Funit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Funit
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFunit($value)
	{
		$this->__Funit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Forder
	 */
	public function getForder()
	{
		if($this->__Forder == null)
		{
			$this->__Forder = new B3it_XmlBind_Opentrans21_Bmecat_Forder();
		}
	
		return $this->__Forder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Forder
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setForder($value)
	{
		$this->__Forder = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Fdescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fdescr
	 */
	public function getFdescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Fdescr();
		$this->__FdescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fdescr
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFdescr($value)
	{
		$this->__FdescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fdescr[]
	 */
	public function getAllFdescr()
	{
		return $this->__FdescrA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FvalueDetails and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FvalueDetails
	 */
	public function getFvalueDetails()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FvalueDetails();
		$this->__FvalueDetailsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FvalueDetails
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFvalueDetails($value)
	{
		$this->__FvalueDetailsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FvalueDetails[]
	 */
	public function getAllFvalueDetails()
	{
		return $this->__FvalueDetailsA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FvalueType
	 */
	public function getFvalueType()
	{
		if($this->__FvalueType == null)
		{
			$this->__FvalueType = new B3it_XmlBind_Opentrans21_Bmecat_FvalueType();
		}
	
		return $this->__FvalueType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FvalueType
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function setFvalueType($value)
	{
		$this->__FvalueType = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('FEATURE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FnameA != null){
			foreach($this->__FnameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtIdref != null){
			$this->__FtIdref->toXml($xml);
		}
		if($this->__Ftemplate != null){
			$this->__Ftemplate->toXml($xml);
		}
		if($this->__FvalueA != null){
			foreach($this->__FvalueA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ValueIdrefA != null){
			foreach($this->__ValueIdrefA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Funit != null){
			$this->__Funit->toXml($xml);
		}
		if($this->__Forder != null){
			$this->__Forder->toXml($xml);
		}
		if($this->__FdescrA != null){
			foreach($this->__FdescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FvalueDetailsA != null){
			foreach($this->__FvalueDetailsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FvalueType != null){
			$this->__FvalueType->toXml($xml);
		}


		return $xml;
	}

}
