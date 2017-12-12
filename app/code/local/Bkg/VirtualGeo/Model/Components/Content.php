<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Format_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Content extends Bkg_VirtualGeo_Model_Components_Component
{

	//alias der Tabelle für die Verbindung zum Produkt
	protected $_productRelationTable = 'virtualgeo/components_content_product';
	
	
	public function _construct()
	{
		parent::_construct();
		$this->_init('virtualgeo/components_content');
	}
	
	public function getOptions4Product($productId,$storeId=0)
	{
		$collection = $this->getCollection();
		$collection->setStoreId($storeId);
		$collection->getSelect()
		->join(array('product'=>$collection->getTable($this->_productRelationTable)),"product.entity_id = main_table.id AND product_id={$productId} AND ((product.store_id= 0) OR (product.store_id={$storeId}))",
			array('is_default','component_product_relation_id'=>'id','parent_node_id'));
		 
		return $collection;
	}
}
