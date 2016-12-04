<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ProductComponent
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ProductComponent extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ProductId */
	private $__ProductId = null;

	/* @var B3it_XmlBind_Opentrans21_ProductFeatures */
	private $__ProductFeatures = null;

	/* @var B3it_XmlBind_Opentrans21_ProductComponents */
	private $__ProductComponents = null;

	/* @var B3it_XmlBind_Opentrans21_Quantity */
	private $__Quantity = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_OrderUnit */
	private $__OrderUnit = null;

	/* @var B3it_XmlBind_Opentrans21_ProductPriceFix */
	private $__ProductPriceFix = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductId
	 */
	public function getProductId()
	{
		if($this->__ProductId == null)
		{
			$this->__ProductId = new B3it_XmlBind_Opentrans21_ProductId();
		}
	
		return $this->__ProductId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductId
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function setProductId($value)
	{
		$this->__ProductId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductFeatures
	 */
	public function getProductFeatures()
	{
		if($this->__ProductFeatures == null)
		{
			$this->__ProductFeatures = new B3it_XmlBind_Opentrans21_ProductFeatures();
		}
	
		return $this->__ProductFeatures;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductFeatures
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function setProductFeatures($value)
	{
		$this->__ProductFeatures = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductComponents
	 */
	public function getProductComponents()
	{
		if($this->__ProductComponents == null)
		{
			$this->__ProductComponents = new B3it_XmlBind_Opentrans21_ProductComponents();
		}
	
		return $this->__ProductComponents;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductComponents
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function setProductComponents($value)
	{
		$this->__ProductComponents = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Quantity
	 */
	public function getQuantity()
	{
		if($this->__Quantity == null)
		{
			$this->__Quantity = new B3it_XmlBind_Opentrans21_Quantity();
		}
	
		return $this->__Quantity;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Quantity
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function setQuantity($value)
	{
		$this->__Quantity = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_OrderUnit
	 */
	public function getOrderUnit()
	{
		if($this->__OrderUnit == null)
		{
			$this->__OrderUnit = new B3it_XmlBind_Opentrans21_Bmecat_OrderUnit();
		}
	
		return $this->__OrderUnit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_OrderUnit
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function setOrderUnit($value)
	{
		$this->__OrderUnit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductPriceFix
	 */
	public function getProductPriceFix()
	{
		if($this->__ProductPriceFix == null)
		{
			$this->__ProductPriceFix = new B3it_XmlBind_Opentrans21_ProductPriceFix();
		}
	
		return $this->__ProductPriceFix;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductPriceFix
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function setProductPriceFix($value)
	{
		$this->__ProductPriceFix = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('PRODUCT_COMPONENT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ProductId != null){
			$this->__ProductId->toXml($xml);
		}
		if($this->__ProductFeatures != null){
			$this->__ProductFeatures->toXml($xml);
		}
		if($this->__ProductComponents != null){
			$this->__ProductComponents->toXml($xml);
		}
		if($this->__Quantity != null){
			$this->__Quantity->toXml($xml);
		}
		if($this->__OrderUnit != null){
			$this->__OrderUnit->toXml($xml);
		}
		if($this->__ProductPriceFix != null){
			$this->__ProductPriceFix->toXml($xml);
		}


		return $xml;
	}

}
