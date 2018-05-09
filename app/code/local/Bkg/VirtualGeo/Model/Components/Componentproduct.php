<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Formatproduct
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Componentproduct extends Mage_Core_Model_Abstract
{
    const COMPONENT_TYPE_CONTENT = 1;
    const COMPONENT_TYPE_FORMAT = 2;
    const COMPONENT_TYPE_GEOREF = 3;
    const COMPONENT_TYPE_RESOLUTION = 4;
    const COMPONENT_TYPE_STRUCTURE = 5;
    const COMPONENT_TYPE_ACCOUNTING = 6;


    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'geo_component';

    /**
     * Alle Inhalte die für dieses Produkt und Store verfügbar sind ermittel
     * @param int $productId
     * @param int $storeId
     * @return array| NULL[]
     */
    public function getValue4Product($productId, $storeId = 0)
    {
        $productId = intval($productId);
        $storeId = intval($storeId);
    	$collection = $this->getCollection();
    	$collection->addFieldToFilter('product_id', $productId);
        $collection->addFieldToFilter('store_id', $storeId);
        if (method_exists($this, 'getComponentType') && $this->getComponentType() > 0) {
            $collection->addFieldToFilter('component_type', $this->getComponentType());
        }
    	$res = array();
    	foreach ($collection->getItems() as $item)
    	{
    		$res[] = $item->getEntityId();
    	}
    
    	return $res;
    }
    
    public function getDefaul4Product($productId, $storeId = 0)
    {
        $productId = intval($productId);
    	$storeId = intval($storeId);
    	$collection = $this->getCollection();
        $collection->addFieldToFilter('product_id', $productId);
        $collection->addFieldToFilter('store_id', $storeId);
        if (method_exists($this, 'getComponentType') && $this->getComponentType() > 0) {
            $collection->addFieldToFilter('component_type', $this->getComponentType());
        }
        $collection->addFieldToFilter('is_default', 1);

    	$res = 0;
    	foreach ($collection->getItems() as $item)
    	{
    		$res = $item->getEntityId();
    	}
    
    	return $res;
    }
    
    public function saveDefault($defaultId, $productId, $storeId)
    {
    	$this->getResource()->saveDefault($defaultId, $productId, $storeId);
    }


    /**
     * Alle Inhalte die für dieses Produkt und Store verfügbar sind ermittel
     * @param int $productId
     * @param int $storeId
     * @return array| NULL[]
     */
    public function getComponents4Product($productId, $storeId = 0)
    {
        $productId = intval($productId);
        $storeId = intval($storeId);
        $collection = $this->getCollection();
        $collection->addFieldToFilter('product_id', $productId);
        $collection->addFieldToFilter('store_id', $storeId);
        if (method_exists($this, 'getComponentType') && $this->getComponentType() > 0) {
            $collection->addFieldToFilter('component_type', $this->getComponentType());
        }
        $collection->getSelect()->order('pos');
        $items = $collection->getItems();
        return $items;
    }

    /**
     * Component type
     *
     * @return mixed
     */
    public function getComponentType() {
        return $this->getData('component_type');
    }
}
