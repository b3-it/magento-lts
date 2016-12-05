<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationGroup
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId */
	private $__ClassificationGroupId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId2 */
	private $__ClassificationGroupId2 = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupVersion */
	private $__ClassificationGroupVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupName */
	private $__ClassificationGroupNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupShortname */
	private $__ClassificationGroupShortnameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupDescr */
	private $__ClassificationGroupDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSource */
	private $__ClassificationGroupSource = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupNote */
	private $__ClassificationGroupNoteA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupRemark */
	private $__ClassificationGroupRemarkA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupContacts */
	private $__ClassificationGroupContacts = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupOrder */
	private $__ClassificationGroupOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSynonyms */
	private $__ClassificationGroupSynonyms = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplates */
	private $__ClassificationGroupFeatureTemplates = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupParentId */
	private $__ClassificationGroupParentId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupUdx */
	private $__ClassificationGroupUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId
	 */
	public function getClassificationGroupId()
	{
		if($this->__ClassificationGroupId == null)
		{
			$this->__ClassificationGroupId = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId();
		}
	
		return $this->__ClassificationGroupId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupId($value)
	{
		$this->__ClassificationGroupId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId2
	 */
	public function getClassificationGroupId2()
	{
		if($this->__ClassificationGroupId2 == null)
		{
			$this->__ClassificationGroupId2 = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId2();
		}
	
		return $this->__ClassificationGroupId2;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupId2
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupId2($value)
	{
		$this->__ClassificationGroupId2 = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupVersion
	 */
	public function getClassificationGroupVersion()
	{
		if($this->__ClassificationGroupVersion == null)
		{
			$this->__ClassificationGroupVersion = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupVersion();
		}
	
		return $this->__ClassificationGroupVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupVersion($value)
	{
		$this->__ClassificationGroupVersion = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupName
	 */
	public function getClassificationGroupName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupName();
		$this->__ClassificationGroupNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupName($value)
	{
		$this->__ClassificationGroupNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupName[]
	 */
	public function getAllClassificationGroupName()
	{
		return $this->__ClassificationGroupNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupShortname and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupShortname
	 */
	public function getClassificationGroupShortname()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupShortname();
		$this->__ClassificationGroupShortnameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupShortname
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupShortname($value)
	{
		$this->__ClassificationGroupShortnameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupShortname[]
	 */
	public function getAllClassificationGroupShortname()
	{
		return $this->__ClassificationGroupShortnameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupDescr
	 */
	public function getClassificationGroupDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupDescr();
		$this->__ClassificationGroupDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupDescr($value)
	{
		$this->__ClassificationGroupDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupDescr[]
	 */
	public function getAllClassificationGroupDescr()
	{
		return $this->__ClassificationGroupDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSource
	 */
	public function getClassificationGroupSource()
	{
		if($this->__ClassificationGroupSource == null)
		{
			$this->__ClassificationGroupSource = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSource();
		}
	
		return $this->__ClassificationGroupSource;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSource
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupSource($value)
	{
		$this->__ClassificationGroupSource = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupNote and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupNote
	 */
	public function getClassificationGroupNote()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupNote();
		$this->__ClassificationGroupNoteA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupNote
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupNote($value)
	{
		$this->__ClassificationGroupNoteA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupNote[]
	 */
	public function getAllClassificationGroupNote()
	{
		return $this->__ClassificationGroupNoteA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupRemark and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupRemark
	 */
	public function getClassificationGroupRemark()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupRemark();
		$this->__ClassificationGroupRemarkA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupRemark
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupRemark($value)
	{
		$this->__ClassificationGroupRemarkA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupRemark[]
	 */
	public function getAllClassificationGroupRemark()
	{
		return $this->__ClassificationGroupRemarkA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupContacts
	 */
	public function getClassificationGroupContacts()
	{
		if($this->__ClassificationGroupContacts == null)
		{
			$this->__ClassificationGroupContacts = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupContacts();
		}
	
		return $this->__ClassificationGroupContacts;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupContacts
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupContacts($value)
	{
		$this->__ClassificationGroupContacts = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupOrder
	 */
	public function getClassificationGroupOrder()
	{
		if($this->__ClassificationGroupOrder == null)
		{
			$this->__ClassificationGroupOrder = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupOrder();
		}
	
		return $this->__ClassificationGroupOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupOrder($value)
	{
		$this->__ClassificationGroupOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSynonyms
	 */
	public function getClassificationGroupSynonyms()
	{
		if($this->__ClassificationGroupSynonyms == null)
		{
			$this->__ClassificationGroupSynonyms = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSynonyms();
		}
	
		return $this->__ClassificationGroupSynonyms;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSynonyms
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupSynonyms($value)
	{
		$this->__ClassificationGroupSynonyms = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplates
	 */
	public function getClassificationGroupFeatureTemplates()
	{
		if($this->__ClassificationGroupFeatureTemplates == null)
		{
			$this->__ClassificationGroupFeatureTemplates = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplates();
		}
	
		return $this->__ClassificationGroupFeatureTemplates;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplates
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupFeatureTemplates($value)
	{
		$this->__ClassificationGroupFeatureTemplates = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupParentId
	 */
	public function getClassificationGroupParentId()
	{
		if($this->__ClassificationGroupParentId == null)
		{
			$this->__ClassificationGroupParentId = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupParentId();
		}
	
		return $this->__ClassificationGroupParentId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupParentId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupParentId($value)
	{
		$this->__ClassificationGroupParentId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupUdx
	 */
	public function getClassificationGroupUdx()
	{
		if($this->__ClassificationGroupUdx == null)
		{
			$this->__ClassificationGroupUdx = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupUdx();
		}
	
		return $this->__ClassificationGroupUdx;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupUdx
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function setClassificationGroupUdx($value)
	{
		$this->__ClassificationGroupUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ClassificationGroupId != null){
			$this->__ClassificationGroupId->toXml($xml);
		}
		if($this->__ClassificationGroupId2 != null){
			$this->__ClassificationGroupId2->toXml($xml);
		}
		if($this->__ClassificationGroupVersion != null){
			$this->__ClassificationGroupVersion->toXml($xml);
		}
		if($this->__ClassificationGroupNameA != null){
			foreach($this->__ClassificationGroupNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationGroupShortnameA != null){
			foreach($this->__ClassificationGroupShortnameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationGroupDescrA != null){
			foreach($this->__ClassificationGroupDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationGroupSource != null){
			$this->__ClassificationGroupSource->toXml($xml);
		}
		if($this->__ClassificationGroupNoteA != null){
			foreach($this->__ClassificationGroupNoteA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationGroupRemarkA != null){
			foreach($this->__ClassificationGroupRemarkA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationGroupContacts != null){
			$this->__ClassificationGroupContacts->toXml($xml);
		}
		if($this->__ClassificationGroupOrder != null){
			$this->__ClassificationGroupOrder->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__ClassificationGroupSynonyms != null){
			$this->__ClassificationGroupSynonyms->toXml($xml);
		}
		if($this->__ClassificationGroupFeatureTemplates != null){
			$this->__ClassificationGroupFeatureTemplates->toXml($xml);
		}
		if($this->__ClassificationGroupParentId != null){
			$this->__ClassificationGroupParentId->toXml($xml);
		}
		if($this->__ClassificationGroupUdx != null){
			$this->__ClassificationGroupUdx->toXml($xml);
		}


		return $xml;
	}

}
