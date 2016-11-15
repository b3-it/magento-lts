<?php
class B3it_XmlBind_Bmecat2005_FtGroup extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtGroupId */
	private $_FtGroupId = null;	

	/* @var FtGroupName */
	private $_FtGroupNames = array();	

	/* @var FtGroupDescr */
	private $_FtGroupDescrs = array();	

	/* @var FtGroupParentId */
	private $_FtGroupParentIds = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_FtGroupId
	 */
	public function getFtGroupId()
	{
		if($this->_FtGroupId == null)
		{
			$this->_FtGroupId = new B3it_XmlBind_Bmecat2005_FtGroupId();
		}
		
		return $this->_FtGroupId;
	}
	
	/**
	 * @param $value FtGroupId
	 * @return B3it_XmlBind_Bmecat2005_FtGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroupId($value)
	{
		$this->_FtGroupId = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_FtGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroupName($value)
	{
		$this->_FtGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtGroupDescr[]
	 */
	public function getAllFtGroupDescr()
	{
		return $this->_FtGroupDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtGroupDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtGroupDescr
	 */
	public function getFtGroupDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtGroupDescr();
		$this->_FtGroupDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtGroupDescr[]
	 * @return B3it_XmlBind_Bmecat2005_FtGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroupDescr($value)
	{
		$this->_FtGroupDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtGroupParentId[]
	 */
	public function getAllFtGroupParentId()
	{
		return $this->_FtGroupParentIds;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtGroupParentId and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtGroupParentId
	 */
	public function getFtGroupParentId()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtGroupParentId();
		$this->_FtGroupParentIds[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtGroupParentId[]
	 * @return B3it_XmlBind_Bmecat2005_FtGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroupParentId($value)
	{
		$this->_FtGroupParentId = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_GROUP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtGroupId != null){
			$this->_FtGroupId->toXml($xml);
		}
		if($this->_FtGroupNames != null){
			foreach($this->_FtGroupNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtGroupDescrs != null){
			foreach($this->_FtGroupDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtGroupParentIds != null){
			foreach($this->_FtGroupParentIds as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}