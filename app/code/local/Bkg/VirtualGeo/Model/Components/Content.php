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
		$contentProductModel = Mage::getModel('virtualgeo/components_contentproduct');
		$contentOptionValueTable = $contentProductModel->getResource()->getContentOptionValueTable();
		$contentOptionValueFields = $contentProductModel->getResource()->getOptionValueAdditionalFields();
		$contentOptionValueFields['node_id'] = 'id';
		$contentOptionValueEntityIdFieldName = $contentProductModel->getResource()->getOptionValueEntityIdFieldName();
		$collection = $contentProductModel->getCollection();
		//$collection->setStoreId($storeId);

        $conditionLabel = array(
            'label.entity_id=main_table.entity_id',
            $collection->getConnection()->quoteInto('label.store_id=?', (int)$this->getStoreId()),
            $collection->getConnection()->quoteInto('main_table.component_type=?', (int)$contentProductModel->getComponentType()),
        );

        $conditionCode = array(
            "main_table.entity_id = entity.id",
            $collection->getConnection()->quoteInto('main_table.component_type=?', (int)$contentProductModel->getComponentType()),
        );

        $conditionAdditional = array(
            "main_table.id = additional.entity_id",
            $collection->getConnection()->quoteInto('main_table.component_type=?', (int)$contentProductModel->getComponentType()),
        );
		$collection->getSelect()
            ->join(
                array('label'=>$this->getCollection()->getLabelTable()),
                join(' AND ', $conditionLabel),
                array('entity_id','shortname','name','description'))
            ->join(
                array('entity'=>$this->getCollection()->getMainTable()),
                join(' AND ', $conditionCode),
                array('code'))
            ->join(
                array('additional' => $contentOptionValueTable),
                join(' AND ', $conditionAdditional),
                $contentOptionValueFields
            )
            ->where("main_table.product_id={$productId}")
            ->where(new Zend_Db_Expr("((main_table.store_id= 0) OR (main_table.store_id={$storeId}))"))
            ->where('main_table.component_type=?', (int)$contentProductModel->getComponentType())
        ;
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
