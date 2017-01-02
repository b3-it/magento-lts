<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Layer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Layer extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Service_Name */
	private $__Name = null;

	/* @var B3it_XmlBind_Wms13_Title */
	private $__Title = null;

	/* @var B3it_XmlBind_Wms13_Abstract */
	private $__Abstract = null;

	/* @var B3it_XmlBind_Wms13_Keywordlist */
	private $__Keywordlist = null;

	
	/* @var B3it_XmlBind_Wms13_Boundingbox_Crs */
	private $__CrsA = array();

	/* @var B3it_XmlBind_Wms13_ExGeographicboundingbox */
	private $__ExGeographicboundingbox = null;

	
	/* @var B3it_XmlBind_Wms13_Boundingbox */
	private $__BoundingboxA = array();

	
	/* @var B3it_XmlBind_Wms13_Dimension */
	private $__DimensionA = array();

	/* @var B3it_XmlBind_Wms13_Attribution */
	private $__Attribution = null;

	
	/* @var B3it_XmlBind_Wms13_Authorityurl */
	private $__AuthorityurlA = array();

	
	/* @var B3it_XmlBind_Wms13_Identifier */
	private $__IdentifierA = array();

	
	/* @var B3it_XmlBind_Wms13_Metadataurl */
	private $__MetadataurlA = array();

	
	/* @var B3it_XmlBind_Wms13_Dataurl */
	private $__DataurlA = array();

	
	/* @var B3it_XmlBind_Wms13_Featurelisturl */
	private $__FeaturelisturlA = array();

	
	/* @var B3it_XmlBind_Wms13_Style */
	private $__StyleA = array();

	/* @var B3it_XmlBind_Wms13_Minscaledenominator */
	private $__Minscaledenominator = null;

	/* @var B3it_XmlBind_Wms13_Maxscaledenominator */
	private $__Maxscaledenominator = null;

	
	/* @var B3it_XmlBind_Wms13_Layer */
	private $__LayerA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Service_Name
	 */
	public function getName()
	{
		if($this->__Name == null)
		{
			$this->__Name = new B3it_XmlBind_Wms13_Service_Name();
		}
	
		return $this->__Name;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Service_Name
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setName($value)
	{
		$this->__Name = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Title
	 */
	public function getTitle()
	{
		if($this->__Title == null)
		{
			$this->__Title = new B3it_XmlBind_Wms13_Title();
		}
	
		return $this->__Title;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Title
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setTitle($value)
	{
		$this->__Title = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Abstract
	 */
	public function getAbstract()
	{
		if($this->__Abstract == null)
		{
			$this->__Abstract = new B3it_XmlBind_Wms13_Abstract();
		}
	
		return $this->__Abstract;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Abstract
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setAbstract($value)
	{
		$this->__Abstract = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Keywordlist
	 */
	public function getKeywordlist()
	{
		if($this->__Keywordlist == null)
		{
			$this->__Keywordlist = new B3it_XmlBind_Wms13_Keywordlist();
		}
	
		return $this->__Keywordlist;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Keywordlist
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setKeywordlist($value)
	{
		$this->__Keywordlist = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Boundingbox_Crs and add it to list
	 * @return B3it_XmlBind_Wms13_Boundingbox_Crs
	 */
	public function getCrs()
	{
		$res = new B3it_XmlBind_Wms13_Boundingbox_Crs();
		$this->__CrsA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Boundingbox_Crs
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setCrs($value)
	{
		$this->__CrsA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Boundingbox_Crs[]
	 */
	public function getAllCrs()
	{
		return $this->__CrsA;
	}


	
	/**
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox
	 */
	public function getExGeographicboundingbox()
	{
		if($this->__ExGeographicboundingbox == null)
		{
			$this->__ExGeographicboundingbox = new B3it_XmlBind_Wms13_ExGeographicboundingbox();
		}
	
		return $this->__ExGeographicboundingbox;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_ExGeographicboundingbox
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setExGeographicboundingbox($value)
	{
		$this->__ExGeographicboundingbox = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Boundingbox and add it to list
	 * @return B3it_XmlBind_Wms13_Boundingbox
	 */
	public function getBoundingbox()
	{
		$res = new B3it_XmlBind_Wms13_Boundingbox();
		$this->__BoundingboxA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Boundingbox
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setBoundingbox($value)
	{
		$this->__BoundingboxA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Boundingbox[]
	 */
	public function getAllBoundingbox()
	{
		return $this->__BoundingboxA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Dimension and add it to list
	 * @return B3it_XmlBind_Wms13_Dimension
	 */
	public function getDimension()
	{
		$res = new B3it_XmlBind_Wms13_Dimension();
		$this->__DimensionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Dimension
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setDimension($value)
	{
		$this->__DimensionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Dimension[]
	 */
	public function getAllDimension()
	{
		return $this->__DimensionA;
	}


	
	/**
	 * @return B3it_XmlBind_Wms13_Attribution
	 */
	public function getAttribution()
	{
		if($this->__Attribution == null)
		{
			$this->__Attribution = new B3it_XmlBind_Wms13_Attribution();
		}
	
		return $this->__Attribution;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Attribution
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setAttribution($value)
	{
		$this->__Attribution = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Authorityurl and add it to list
	 * @return B3it_XmlBind_Wms13_Authorityurl
	 */
	public function getAuthorityurl()
	{
		$res = new B3it_XmlBind_Wms13_Authorityurl();
		$this->__AuthorityurlA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Authorityurl
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setAuthorityurl($value)
	{
		$this->__AuthorityurlA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Authorityurl[]
	 */
	public function getAllAuthorityurl()
	{
		return $this->__AuthorityurlA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Identifier and add it to list
	 * @return B3it_XmlBind_Wms13_Identifier
	 */
	public function getIdentifier()
	{
		$res = new B3it_XmlBind_Wms13_Identifier();
		$this->__IdentifierA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Identifier
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setIdentifier($value)
	{
		$this->__IdentifierA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Identifier[]
	 */
	public function getAllIdentifier()
	{
		return $this->__IdentifierA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Metadataurl and add it to list
	 * @return B3it_XmlBind_Wms13_Metadataurl
	 */
	public function getMetadataurl()
	{
		$res = new B3it_XmlBind_Wms13_Metadataurl();
		$this->__MetadataurlA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Metadataurl
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setMetadataurl($value)
	{
		$this->__MetadataurlA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Metadataurl[]
	 */
	public function getAllMetadataurl()
	{
		return $this->__MetadataurlA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Dataurl and add it to list
	 * @return B3it_XmlBind_Wms13_Dataurl
	 */
	public function getDataurl()
	{
		$res = new B3it_XmlBind_Wms13_Dataurl();
		$this->__DataurlA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Dataurl
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setDataurl($value)
	{
		$this->__DataurlA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Dataurl[]
	 */
	public function getAllDataurl()
	{
		return $this->__DataurlA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Featurelisturl and add it to list
	 * @return B3it_XmlBind_Wms13_Featurelisturl
	 */
	public function getFeaturelisturl()
	{
		$res = new B3it_XmlBind_Wms13_Featurelisturl();
		$this->__FeaturelisturlA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Featurelisturl
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setFeaturelisturl($value)
	{
		$this->__FeaturelisturlA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Featurelisturl[]
	 */
	public function getAllFeaturelisturl()
	{
		return $this->__FeaturelisturlA;
	}


	

	/**
	 * Create new B3it_XmlBind_Wms13_Style and add it to list
	 * @return B3it_XmlBind_Wms13_Style
	 */
	public function getStyle()
	{
		$res = new B3it_XmlBind_Wms13_Style();
		$this->__StyleA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Style
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setStyle($value)
	{
		$this->__StyleA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Style[]
	 */
	public function getAllStyle()
	{
		return $this->__StyleA;
	}


	
	/**
	 * @return B3it_XmlBind_Wms13_Minscaledenominator
	 */
	public function getMinscaledenominator()
	{
		if($this->__Minscaledenominator == null)
		{
			$this->__Minscaledenominator = new B3it_XmlBind_Wms13_Minscaledenominator();
		}
	
		return $this->__Minscaledenominator;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Minscaledenominator
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setMinscaledenominator($value)
	{
		$this->__Minscaledenominator = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Maxscaledenominator
	 */
	public function getMaxscaledenominator()
	{
		if($this->__Maxscaledenominator == null)
		{
			$this->__Maxscaledenominator = new B3it_XmlBind_Wms13_Maxscaledenominator();
		}
	
		return $this->__Maxscaledenominator;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Maxscaledenominator
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setMaxscaledenominator($value)
	{
		$this->__Maxscaledenominator = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Layer and add it to list
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function getLayer()
	{
		$res = new B3it_XmlBind_Wms13_Layer();
		$this->__LayerA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Layer
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function setLayer($value)
	{
		$this->__LayerA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Layer[]
	 */
	public function getAllLayer()
	{
		return $this->__LayerA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('Layer');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Name != null){
			$this->__Name->toXml($xml);
		}
		if($this->__Title != null){
			$this->__Title->toXml($xml);
		}
		if($this->__Abstract != null){
			$this->__Abstract->toXml($xml);
		}
		if($this->__Keywordlist != null){
			$this->__Keywordlist->toXml($xml);
		}
		if($this->__CrsA != null){
			foreach($this->__CrsA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ExGeographicboundingbox != null){
			$this->__ExGeographicboundingbox->toXml($xml);
		}
		if($this->__BoundingboxA != null){
			foreach($this->__BoundingboxA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DimensionA != null){
			foreach($this->__DimensionA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Attribution != null){
			$this->__Attribution->toXml($xml);
		}
		if($this->__AuthorityurlA != null){
			foreach($this->__AuthorityurlA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__IdentifierA != null){
			foreach($this->__IdentifierA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MetadataurlA != null){
			foreach($this->__MetadataurlA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DataurlA != null){
			foreach($this->__DataurlA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FeaturelisturlA != null){
			foreach($this->__FeaturelisturlA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StyleA != null){
			foreach($this->__StyleA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Minscaledenominator != null){
			$this->__Minscaledenominator->toXml($xml);
		}
		if($this->__Maxscaledenominator != null){
			$this->__Maxscaledenominator->toXml($xml);
		}
		if($this->__LayerA != null){
			foreach($this->__LayerA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
