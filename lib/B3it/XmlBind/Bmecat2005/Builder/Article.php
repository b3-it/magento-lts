<?php

class  B3it_XmlBind_Bmecat2005_Builder_Article extends B3it_XmlBind_Bmecat2005_Builder_Abstract
{
	//die aus dem xml erzeugte Klasse
	/**
	 *  @var B3it_XmlBind_Bmecat2005_TNewCatalog_Article 
	 *  */ 
	protected $_xmlProduct = null;

	public function __construct($xml){
		$this->_xmlProduct = $xml;
	}

	public function build()
	{
		
		
		
		$entityRowsIn[$rowSku] = array(
				'entity_type_id'   => $this->_entityTypeId,
				'attribute_set_id' => $this->_newSku[$rowSku]['attr_set_id'],
				'type_id'          => $this->_newSku[$rowSku]['type_id'],
				'sku'              => $rowSku,
				'created_at'       => now(),
				'updated_at'       => now()
		);
		
		$product = $this->_getProduct();
		$product->setAttributeSetId(4);
		$product->setTypeId('simple');
		$product->setEntityTypeId(4);
		$product->setSku($this->_xmlProduct->getSupplierAid()->getValue());
		$product->setName($this->_xmlProduct->getArticleDetails()->getDescriptionShort()->getValue());
		$product->setShortDescription ($this->_xmlProduct->getArticleDetails()->getDescriptionLong()->getValue());
		$product->setDescription ($this->_xmlProduct->getArticleDetails()->getDescriptionLong()->getValue());
		$product->setWeight (0);
		$product->setManfacturer($this->_xmlProduct->getArticleDetails()->getManufacturerName());
		
		foreach($this->_xmlProduct->getArticlePriceDetails() as $detail)
		{
			foreach($detail->getAllArticlePrice() as $price)
			{
				$product->setPrice($price->getPriceAmount());
			}
		}
		
		return $product;
	}
}