<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Rewards
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Rewards extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_RewardsPoints */
	private $__RewardsPoints = null;

	/* @var B3it_XmlBind_Opentrans21_RewardsSummary */
	private $__RewardsSummary = null;

	/* @var B3it_XmlBind_Opentrans21_RewardsSystem */
	private $__RewardsSystem = null;

	/* @var B3it_XmlBind_Opentrans21_RewardsDescr */
	private $__RewardsDescr = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RewardsPoints
	 */
	public function getRewardsPoints()
	{
		if($this->__RewardsPoints == null)
		{
			$this->__RewardsPoints = new B3it_XmlBind_Opentrans21_RewardsPoints();
		}
	
		return $this->__RewardsPoints;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RewardsPoints
	 * @return B3it_XmlBind_Opentrans21_Rewards
	 */
	public function setRewardsPoints($value)
	{
		$this->__RewardsPoints = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RewardsSummary
	 */
	public function getRewardsSummary()
	{
		if($this->__RewardsSummary == null)
		{
			$this->__RewardsSummary = new B3it_XmlBind_Opentrans21_RewardsSummary();
		}
	
		return $this->__RewardsSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RewardsSummary
	 * @return B3it_XmlBind_Opentrans21_Rewards
	 */
	public function setRewardsSummary($value)
	{
		$this->__RewardsSummary = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RewardsSystem
	 */
	public function getRewardsSystem()
	{
		if($this->__RewardsSystem == null)
		{
			$this->__RewardsSystem = new B3it_XmlBind_Opentrans21_RewardsSystem();
		}
	
		return $this->__RewardsSystem;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RewardsSystem
	 * @return B3it_XmlBind_Opentrans21_Rewards
	 */
	public function setRewardsSystem($value)
	{
		$this->__RewardsSystem = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RewardsDescr
	 */
	public function getRewardsDescr()
	{
		if($this->__RewardsDescr == null)
		{
			$this->__RewardsDescr = new B3it_XmlBind_Opentrans21_RewardsDescr();
		}
	
		return $this->__RewardsDescr;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RewardsDescr
	 * @return B3it_XmlBind_Opentrans21_Rewards
	 */
	public function setRewardsDescr($value)
	{
		$this->__RewardsDescr = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('REWARDS');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RewardsPoints != null){
			$this->__RewardsPoints->toXml($xml);
		}
		if($this->__RewardsSummary != null){
			$this->__RewardsSummary->toXml($xml);
		}
		if($this->__RewardsSystem != null){
			$this->__RewardsSystem->toXml($xml);
		}
		if($this->__RewardsDescr != null){
			$this->__RewardsDescr->toXml($xml);
		}


		return $xml;
	}

}
