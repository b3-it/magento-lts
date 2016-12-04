<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtGroup
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtGroup extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroupId */
	private $__FtGroupId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroupName */
	private $__FtGroupNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroupDescr */
	private $__FtGroupDescrA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroupParentId */
	private $__FtGroupParentIdA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupId
	 */
	public function getFtGroupId()
	{
		if($this->__FtGroupId == null)
		{
			$this->__FtGroupId = new B3it_XmlBind_Opentrans21_Bmecat_FtGroupId();
		}
	
		return $this->__FtGroupId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroupId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroup
	 */
	public function setFtGroupId($value)
	{
		$this->__FtGroupId = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroup
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
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtGroupDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupDescr
	 */
	public function getFtGroupDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtGroupDescr();
		$this->__FtGroupDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroupDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroup
	 */
	public function setFtGroupDescr($value)
	{
		$this->__FtGroupDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupDescr[]
	 */
	public function getAllFtGroupDescr()
	{
		return $this->__FtGroupDescrA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtGroupParentId and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupParentId
	 */
	public function getFtGroupParentId()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtGroupParentId();
		$this->__FtGroupParentIdA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroupParentId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroup
	 */
	public function setFtGroupParentId($value)
	{
		$this->__FtGroupParentIdA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroupParentId[]
	 */
	public function getAllFtGroupParentId()
	{
		return $this->__FtGroupParentIdA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_GROUP');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_GROUP');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtGroupId != null){
			$this->__FtGroupId->toXml($xml);
		}
		if($this->__FtGroupNameA != null){
			foreach($this->__FtGroupNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtGroupDescrA != null){
			foreach($this->__FtGroupDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtGroupParentIdA != null){
			foreach($this->__FtGroupParentIdA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
