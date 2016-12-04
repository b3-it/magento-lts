<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ProductFeatures
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ProductFeatures extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName */
	private $__ReferenceFeatureSystemName = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId */
	private $__ReferenceFeatureGroupIdA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupName */
	private $__ReferenceFeatureGroupNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId2 */
	private $__ReferenceFeatureGroupId2A = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupProductOrder */
	private $__GroupProductOrder = null;

	
	/* @var B3it_XmlBind_Opentrans21_Feature */
	private $__FeatureA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName
	 */
	public function getReferenceFeatureSystemName()
	{
		if($this->__ReferenceFeatureSystemName == null)
		{
			$this->__ReferenceFeatureSystemName = new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName();
		}
	
		return $this->__ReferenceFeatureSystemName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureSystemName
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function setReferenceFeatureSystemName($value)
	{
		$this->__ReferenceFeatureSystemName = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId
	 */
	public function getReferenceFeatureGroupId()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId();
		$this->__ReferenceFeatureGroupIdA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function setReferenceFeatureGroupId($value)
	{
		$this->__ReferenceFeatureGroupIdA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId[]
	 */
	public function getAllReferenceFeatureGroupId()
	{
		return $this->__ReferenceFeatureGroupIdA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupName
	 */
	public function getReferenceFeatureGroupName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupName();
		$this->__ReferenceFeatureGroupNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupName
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function setReferenceFeatureGroupName($value)
	{
		$this->__ReferenceFeatureGroupNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupName[]
	 */
	public function getAllReferenceFeatureGroupName()
	{
		return $this->__ReferenceFeatureGroupNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId2 and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId2
	 */
	public function getReferenceFeatureGroupId2()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId2();
		$this->__ReferenceFeatureGroupId2A[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId2
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function setReferenceFeatureGroupId2($value)
	{
		$this->__ReferenceFeatureGroupId2A[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ReferenceFeatureGroupId2[]
	 */
	public function getAllReferenceFeatureGroupId2()
	{
		return $this->__ReferenceFeatureGroupId2A;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupProductOrder
	 */
	public function getGroupProductOrder()
	{
		if($this->__GroupProductOrder == null)
		{
			$this->__GroupProductOrder = new B3it_XmlBind_Opentrans21_Bmecat_GroupProductOrder();
		}
	
		return $this->__GroupProductOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupProductOrder
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function setGroupProductOrder($value)
	{
		$this->__GroupProductOrder = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Feature and add it to list
	 * @return B3it_XmlBind_Opentrans21_Feature
	 */
	public function getFeature()
	{
		$res = new B3it_XmlBind_Opentrans21_Feature();
		$this->__FeatureA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Feature
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function setFeature($value)
	{
		$this->__FeatureA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Feature[]
	 */
	public function getAllFeature()
	{
		return $this->__FeatureA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('PRODUCT_FEATURES');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ReferenceFeatureSystemName != null){
			$this->__ReferenceFeatureSystemName->toXml($xml);
		}
		if($this->__ReferenceFeatureGroupIdA != null){
			foreach($this->__ReferenceFeatureGroupIdA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ReferenceFeatureGroupNameA != null){
			foreach($this->__ReferenceFeatureGroupNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ReferenceFeatureGroupId2A != null){
			foreach($this->__ReferenceFeatureGroupId2A as $item){
				$item->toXml($xml);
			}
		}
		if($this->__GroupProductOrder != null){
			$this->__GroupProductOrder->toXml($xml);
		}
		if($this->__FeatureA != null){
			foreach($this->__FeatureA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
