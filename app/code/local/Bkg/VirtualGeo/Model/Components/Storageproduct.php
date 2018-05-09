<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Storageproduct
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Storageproduct extends Bkg_VirtualGeo_Model_Components_Componentproduct
{
    protected $_eventPrefix = 'virtualgeo_components_storageproduct';

    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_storageproduct');
    }
    
    /**
     * Alle Inhalte die für dieses Produkt und Store verfügbar sind ermittel
     * @param int $productId
     * @param int $storeId
     * @return array| NULL[]
     */
    public function getComponents4Product($productId, $storeId = 0)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$productId = intval($productId);
    	$storeId = intval($storeId);
    	$collection = $this->getCollection();
    	$collection->getSelect()
    		->join(array('product'=>$collection->getTable('catalog/product')),'product.entity_id = main_table.transport_product_id',array('sku'))
    		->join(array('product_label'=>$collection->getTable('catalog/product').'_varchar'),'product_label.entity_id = main_table.transport_product_id AND product_label.store_id=0 AND attribute_id='.$eav->getIdByCode('catalog_product', 'name'),array('product_name'=>'value'))  	
    		->where('main_table.product_id=?',$productId)
    		->where('main_table.store_id=?',$storeId)
    		->order('pos');
    	
    	foreach($collection->getItems() as $item)
    	{
    		$item->setTransportProductLabel($item->getSku().", ". $item->getProductName());
    	}

    	return $collection->getItems();
    }
}
