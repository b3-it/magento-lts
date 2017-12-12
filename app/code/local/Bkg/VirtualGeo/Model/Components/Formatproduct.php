<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Model_Components_Formatproduct
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Virtualgeo_Model_Components_Formatproduct extends Mage_Core_Model_Abstract
{
	
		
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_formatproduct');
    }
    

    /**
     * Alle Formate die für dieses Produkt und Store verfügbar sind ermittel
     * @param int $productId
     * @param int $storeId
     * @return array| NULL[]
     */
    public function getValue4Product($productId, $storeId = 0)
    {
    	$storeId = intval($storeId);
    	$collection = $this->getCollection();
    	$collection->getSelect()->where('product_id=?',$productId);
    	$collection->getSelect()->where('store_id=?',$storeId);
    	$res = array();
    	foreach ($collection->getItems() as $item)
    	{
    		$res[] = $item->getFormatId();
    	}
    
    	return $res;
    }
    
    public function getDefaul4Product($productId, $storeId = 0)
    {
    	$storeId = intval($storeId);
    	$collection = $this->getCollection();
    	$collection->getSelect()->where('product_id=?',$productId);
    	$collection->getSelect()->where('store_id=?',$storeId);
    	$collection->getSelect()->where('is_default=?','1');
    	
    	$res = 0;
    	foreach ($collection->getItems() as $item)
    	{
    		$res = $item->getFormatId();
    	}
    
    	return $res;
    }
    
    public function saveDefault($defaultId, $productId, $storeId)
    {
    	$this->getResource()->saveDefault($defaultId, $productId, $storeId);
    }
}
