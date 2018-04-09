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
        $productId = intval($productId);
        $storeId = intval($storeId);
		$collection = Mage::getModel('virtualgeo/components_contentproduct')->getCollection();

		//$collection->setStoreId($storeId);


		$collection->getSelect()
            ->join(array('label'=>$this->getCollection()->getLabelTable()), "label.entity_id=main_table.entity_id AND label.store_id=".$this->getStoreId(),array('entity_id','shortname','name','description'))
            ->join(array('entity'=>$this->getCollection()->getMainTable()),"main_table.entity_id = entity.id",array('code'))
            ->where("main_table.product_id={$productId}")
            ->where(new Zend_Db_Expr("((main_table.store_id= 0) OR (main_table.store_id={$storeId}))"));
		//die($collection->getSelect()->__toString());
		return $collection;
	}
	
	public function getCollectionAsOptions($productId,$storeId = 0)
	{
		$res = array();
		$collection = $this->getCollection();
		$collection->setStoreId($storeId);
		foreach($collection->getItems() as $item)
		{
			$res[] = array('label'=>trim($item->getName() ." " . $item->getDescription()),'value' => $item->getId());
		}
	
		return $res;
	}
}
