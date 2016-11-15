<?php
class B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtId */
	private $_FtId = null;	

	/* @var FtName */
	private $_FtNames = array();	

	/* @var FtShortname */
	private $_FtShortnames = array();	

	/* @var FtDescr */
	private $_FtDescrs = array();	

	/* @var FtVersion */
	private $_FtVersion = null;	

	/* @var FtGroupIdref */
	private $_FtGroupIdref = null;	

	/* @var FtGroupName */
	private $_FtGroupNames = array();	

	/* @var FtDependencies */
	private $_FtDependencies = null;	

	/* @var FeatureContent */
	private $_FeatureContent = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_FtId
	 */
	public function getFtId()
	{
		if($this->_FtId == null)
		{
			$this->_FtId = new B3it_XmlBind_Bmecat2005_FtId();
		}
		
		return $this->_FtId;
	}
	
	/**
	 * @param $value FtId
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtId($value)
	{
		$this->_FtId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtName[]
	 */
	public function getAllFtName()
	{
		return $this->_FtNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtName
	 */
	public function getFtName()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtName();
		$this->_FtNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtName[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtName($value)
	{
		$this->_FtName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtShortname[]
	 */
	public function getAllFtShortname()
	{
		return $this->_FtShortnames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtShortname and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtShortname
	 */
	public function getFtShortname()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtShortname();
		$this->_FtShortnames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtShortname[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtShortname($value)
	{
		$this->_FtShortname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtDescr[]
	 */
	public function getAllFtDescr()
	{
		return $this->_FtDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtDescr
	 */
	public function getFtDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtDescr();
		$this->_FtDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtDescr($value)
	{
		$this->_FtDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtVersion
	 */
	public function getFtVersion()
	{
		if($this->_FtVersion == null)
		{
			$this->_FtVersion = new B3it_XmlBind_Bmecat2005_FtVersion();
		}
		
		return $this->_FtVersion;
	}
	
	/**
	 * @param $value FtVersion
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtVersion($value)
	{
		$this->_FtVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtGroupIdref
	 */
	public function getFtGroupIdref()
	{
		if($this->_FtGroupIdref == null)
		{
			$this->_FtGroupIdref = new B3it_XmlBind_Bmecat2005_FtGroupIdref();
		}
		
		return $this->_FtGroupIdref;
	}
	
	/**
	 * @param $value FtGroupIdref
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroupIdref($value)
	{
		$this->_FtGroupIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtGroupName[]
	 */
	public function getAllFtGroupName()
	{
		return $this->_FtGroupNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtGroupName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtGroupName
	 */
	public function getFtGroupName()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtGroupName();
		$this->_FtGroupNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtGroupName[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroupName($value)
	{
		$this->_FtGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtDependencies
	 */
	public function getFtDependencies()
	{
		if($this->_FtDependencies == null)
		{
			$this->_FtDependencies = new B3it_XmlBind_Bmecat2005_FtDependencies();
		}
		
		return $this->_FtDependencies;
	}
	
	/**
	 * @param $value FtDependencies
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtDependencies($value)
	{
		$this->_FtDependencies = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FeatureContent
	 */
	public function getFeatureContent()
	{
		if($this->_FeatureContent == null)
		{
			$this->_FeatureContent = new B3it_XmlBind_Bmecat2005_FeatureContent();
		}
		
		return $this->_FeatureContent;
	}
	
	/**
	 * @param $value FeatureContent
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFeatureContent($value)
	{
		$this->_FeatureContent = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_SYSTEM_FEATURE_TEMPLATE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtId != null){
			$this->_FtId->toXml($xml);
		}
		if($this->_FtNames != null){
			foreach($this->_FtNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtShortnames != null){
			foreach($this->_FtShortnames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtDescrs != null){
			foreach($this->_FtDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtVersion != null){
			$this->_FtVersion->toXml($xml);
		}
		if($this->_FtGroupIdref != null){
			$this->_FtGroupIdref->toXml($xml);
		}
		if($this->_FtGroupNames != null){
			foreach($this->_FtGroupNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtDependencies != null){
			$this->_FtDependencies->toXml($xml);
		}
		if($this->_FeatureContent != null){
			$this->_FeatureContent->toXml($xml);
		}


		return $xml;
	}
}