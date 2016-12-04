<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Typeftemplate
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtId */
	private $__FtId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtName */
	private $__FtNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtShortname */
	private $__FtShortnameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtDescr */
	private $__FtDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtVersion */
	private $__FtVersion = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroupIdref */
	private $__FtGroupIdref = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroupName */
	private $__FtGroupNameA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtDependencies */
	private $__FtDependencies = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FeatureContent */
	private $__FeatureContent = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtId
	 */
	public function getFtId()
	{
		if($this->__FtId == null)
		{
			$this->__FtId = new B3it_XmlBind_Opentrans21_Bmecat_FtId();
		}
	
		return $this->__FtId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtId($value)
	{
		$this->__FtId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtName
	 */
	public function getFtName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtName();
		$this->__FtNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtName($value)
	{
		$this->__FtNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtName[]
	 */
	public function getAllFtName()
	{
		return $this->__FtNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtShortname and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtShortname
	 */
	public function getFtShortname()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtShortname();
		$this->__FtShortnameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtShortname
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtShortname($value)
	{
		$this->__FtShortnameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtShortname[]
	 */
	public function getAllFtShortname()
	{
		return $this->__FtShortnameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtDescr
	 */
	public function getFtDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtDescr();
		$this->__FtDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtDescr($value)
	{
		$this->__FtDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtDescr[]
	 */
	public function getAllFtDescr()
	{
		return $this->__FtDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtVersion
	 */
	public function getFtVersion()
	{
		if($this->__FtVersion == null)
		{
			$this->__FtVersion = new B3it_XmlBind_Opentrans21_Bmecat_FtVersion();
		}
	
		return $this->__FtVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtVersion($value)
	{
		$this->__FtVersion = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupIdref
	 */
	public function getFtGroupIdref()
	{
		if($this->__FtGroupIdref == null)
		{
			$this->__FtGroupIdref = new B3it_XmlBind_Opentrans21_Bmecat_FtGroupIdref();
		}
	
		return $this->__FtGroupIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroupIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtGroupIdref($value)
	{
		$this->__FtGroupIdref = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtGroupName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupName
	 */
	public function getFtGroupName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtGroupName();
		$this->__FtGroupNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroupName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtGroupName($value)
	{
		$this->__FtGroupNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupName[]
	 */
	public function getAllFtGroupName()
	{
		return $this->__FtGroupNameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtDependencies
	 */
	public function getFtDependencies()
	{
		if($this->__FtDependencies == null)
		{
			$this->__FtDependencies = new B3it_XmlBind_Opentrans21_Bmecat_FtDependencies();
		}
	
		return $this->__FtDependencies;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtDependencies
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFtDependencies($value)
	{
		$this->__FtDependencies = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FeatureContent
	 */
	public function getFeatureContent()
	{
		if($this->__FeatureContent == null)
		{
			$this->__FeatureContent = new B3it_XmlBind_Opentrans21_Bmecat_FeatureContent();
		}
	
		return $this->__FeatureContent;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FeatureContent
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typeftemplate
	 */
	public function setFeatureContent($value)
	{
		$this->__FeatureContent = $value;
		return $this;
	}





	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtId != null){
			$this->__FtId->toXml($xml);
		}
		if($this->__FtNameA != null){
			foreach($this->__FtNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtShortnameA != null){
			foreach($this->__FtShortnameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtDescrA != null){
			foreach($this->__FtDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtVersion != null){
			$this->__FtVersion->toXml($xml);
		}
		if($this->__FtGroupIdref != null){
			$this->__FtGroupIdref->toXml($xml);
		}
		if($this->__FtGroupNameA != null){
			foreach($this->__FtGroupNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtDependencies != null){
			$this->__FtDependencies->toXml($xml);
		}
		if($this->__FeatureContent != null){
			$this->__FeatureContent->toXml($xml);
		}


		return $xml;
	}

}
