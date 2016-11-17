<?php
class B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationGroupId */
	private $_ClassificationGroupId = null;	

	/* @var ClassificationGroupId2 */
	private $_ClassificationGroupId2 = null;	

	/* @var ClassificationGroupVersion */
	private $_ClassificationGroupVersion = null;	

	/* @var ClassificationGroupName */
	private $_ClassificationGroupNames = array();	

	/* @var ClassificationGroupShortname */
	private $_ClassificationGroupShortnames = array();	

	/* @var ClassificationGroupDescr */
	private $_ClassificationGroupDescrs = array();	

	/* @var ClassificationGroupSource */
	private $_ClassificationGroupSource = null;	

	/* @var ClassificationGroupNote */
	private $_ClassificationGroupNotes = array();	

	/* @var ClassificationGroupRemark */
	private $_ClassificationGroupRemarks = array();	

	/* @var ClassificationGroupContacts */
	private $_ClassificationGroupContacts = null;	

	/* @var ClassificationGroupOrder */
	private $_ClassificationGroupOrder = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var ClassificationGroupSynonyms */
	private $_ClassificationGroupSynonyms = null;	

	/* @var ClassificationGroupFeatureTemplates */
	private $_ClassificationGroupFeatureTemplates = null;	

	/* @var ClassificationGroupParentId */
	private $_ClassificationGroupParentId = null;	

	/* @var ClassificationGroupUdx */
	private $_ClassificationGroupUdx = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupId
	 */
	public function getClassificationGroupId()
	{
		if($this->_ClassificationGroupId == null)
		{
			$this->_ClassificationGroupId = new B3it_XmlBind_Bmecat2005_ClassificationGroupId();
		}
		
		return $this->_ClassificationGroupId;
	}
	
	/**
	 * @param $value ClassificationGroupId
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupId($value)
	{
		$this->_ClassificationGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupId2
	 */
	public function getClassificationGroupId2()
	{
		if($this->_ClassificationGroupId2 == null)
		{
			$this->_ClassificationGroupId2 = new B3it_XmlBind_Bmecat2005_ClassificationGroupId2();
		}
		
		return $this->_ClassificationGroupId2;
	}
	
	/**
	 * @param $value ClassificationGroupId2
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupId2($value)
	{
		$this->_ClassificationGroupId2 = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupVersion
	 */
	public function getClassificationGroupVersion()
	{
		if($this->_ClassificationGroupVersion == null)
		{
			$this->_ClassificationGroupVersion = new B3it_XmlBind_Bmecat2005_ClassificationGroupVersion();
		}
		
		return $this->_ClassificationGroupVersion;
	}
	
	/**
	 * @param $value ClassificationGroupVersion
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupVersion($value)
	{
		$this->_ClassificationGroupVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupName[]
	 */
	public function getAllClassificationGroupName()
	{
		return $this->_ClassificationGroupNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationGroupName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupName
	 */
	public function getClassificationGroupName()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationGroupName();
		$this->_ClassificationGroupNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroupName[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupName($value)
	{
		$this->_ClassificationGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupShortname[]
	 */
	public function getAllClassificationGroupShortname()
	{
		return $this->_ClassificationGroupShortnames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationGroupShortname and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupShortname
	 */
	public function getClassificationGroupShortname()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationGroupShortname();
		$this->_ClassificationGroupShortnames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroupShortname[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupShortname($value)
	{
		$this->_ClassificationGroupShortname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupDescr[]
	 */
	public function getAllClassificationGroupDescr()
	{
		return $this->_ClassificationGroupDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationGroupDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupDescr
	 */
	public function getClassificationGroupDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationGroupDescr();
		$this->_ClassificationGroupDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroupDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupDescr($value)
	{
		$this->_ClassificationGroupDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupSource
	 */
	public function getClassificationGroupSource()
	{
		if($this->_ClassificationGroupSource == null)
		{
			$this->_ClassificationGroupSource = new B3it_XmlBind_Bmecat2005_ClassificationGroupSource();
		}
		
		return $this->_ClassificationGroupSource;
	}
	
	/**
	 * @param $value ClassificationGroupSource
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupSource($value)
	{
		$this->_ClassificationGroupSource = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupNote[]
	 */
	public function getAllClassificationGroupNote()
	{
		return $this->_ClassificationGroupNotes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationGroupNote and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupNote
	 */
	public function getClassificationGroupNote()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationGroupNote();
		$this->_ClassificationGroupNotes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroupNote[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupNote($value)
	{
		$this->_ClassificationGroupNote = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupRemark[]
	 */
	public function getAllClassificationGroupRemark()
	{
		return $this->_ClassificationGroupRemarks;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationGroupRemark and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupRemark
	 */
	public function getClassificationGroupRemark()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationGroupRemark();
		$this->_ClassificationGroupRemarks[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationGroupRemark[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupRemark($value)
	{
		$this->_ClassificationGroupRemark = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupContacts
	 */
	public function getClassificationGroupContacts()
	{
		if($this->_ClassificationGroupContacts == null)
		{
			$this->_ClassificationGroupContacts = new B3it_XmlBind_Bmecat2005_ClassificationGroupContacts();
		}
		
		return $this->_ClassificationGroupContacts;
	}
	
	/**
	 * @param $value ClassificationGroupContacts
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupContacts($value)
	{
		$this->_ClassificationGroupContacts = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupOrder
	 */
	public function getClassificationGroupOrder()
	{
		if($this->_ClassificationGroupOrder == null)
		{
			$this->_ClassificationGroupOrder = new B3it_XmlBind_Bmecat2005_ClassificationGroupOrder();
		}
		
		return $this->_ClassificationGroupOrder;
	}
	
	/**
	 * @param $value ClassificationGroupOrder
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupOrder($value)
	{
		$this->_ClassificationGroupOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupSynonyms
	 */
	public function getClassificationGroupSynonyms()
	{
		if($this->_ClassificationGroupSynonyms == null)
		{
			$this->_ClassificationGroupSynonyms = new B3it_XmlBind_Bmecat2005_ClassificationGroupSynonyms();
		}
		
		return $this->_ClassificationGroupSynonyms;
	}
	
	/**
	 * @param $value ClassificationGroupSynonyms
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupSynonyms($value)
	{
		$this->_ClassificationGroupSynonyms = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplates
	 */
	public function getClassificationGroupFeatureTemplates()
	{
		if($this->_ClassificationGroupFeatureTemplates == null)
		{
			$this->_ClassificationGroupFeatureTemplates = new B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplates();
		}
		
		return $this->_ClassificationGroupFeatureTemplates;
	}
	
	/**
	 * @param $value ClassificationGroupFeatureTemplates
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupFeatureTemplates($value)
	{
		$this->_ClassificationGroupFeatureTemplates = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupParentId
	 */
	public function getClassificationGroupParentId()
	{
		if($this->_ClassificationGroupParentId == null)
		{
			$this->_ClassificationGroupParentId = new B3it_XmlBind_Bmecat2005_ClassificationGroupParentId();
		}
		
		return $this->_ClassificationGroupParentId;
	}
	
	/**
	 * @param $value ClassificationGroupParentId
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupParentId($value)
	{
		$this->_ClassificationGroupParentId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupUdx
	 */
	public function getClassificationGroupUdx()
	{
		if($this->_ClassificationGroupUdx == null)
		{
			$this->_ClassificationGroupUdx = new B3it_XmlBind_Bmecat2005_ClassificationGroupUdx();
		}
		
		return $this->_ClassificationGroupUdx;
	}
	
	/**
	 * @param $value ClassificationGroupUdx
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroup extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationGroupUdx($value)
	{
		$this->_ClassificationGroupUdx = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_GROUP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationGroupId != null){
			$this->_ClassificationGroupId->toXml($xml);
		}
		if($this->_ClassificationGroupId2 != null){
			$this->_ClassificationGroupId2->toXml($xml);
		}
		if($this->_ClassificationGroupVersion != null){
			$this->_ClassificationGroupVersion->toXml($xml);
		}
		if($this->_ClassificationGroupNames != null){
			foreach($this->_ClassificationGroupNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationGroupShortnames != null){
			foreach($this->_ClassificationGroupShortnames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationGroupDescrs != null){
			foreach($this->_ClassificationGroupDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationGroupSource != null){
			$this->_ClassificationGroupSource->toXml($xml);
		}
		if($this->_ClassificationGroupNotes != null){
			foreach($this->_ClassificationGroupNotes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationGroupRemarks != null){
			foreach($this->_ClassificationGroupRemarks as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationGroupContacts != null){
			$this->_ClassificationGroupContacts->toXml($xml);
		}
		if($this->_ClassificationGroupOrder != null){
			$this->_ClassificationGroupOrder->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_ClassificationGroupSynonyms != null){
			$this->_ClassificationGroupSynonyms->toXml($xml);
		}
		if($this->_ClassificationGroupFeatureTemplates != null){
			$this->_ClassificationGroupFeatureTemplates->toXml($xml);
		}
		if($this->_ClassificationGroupParentId != null){
			$this->_ClassificationGroupParentId->toXml($xml);
		}
		if($this->_ClassificationGroupUdx != null){
			$this->_ClassificationGroupUdx->toXml($xml);
		}


		return $xml;
	}
}