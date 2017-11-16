<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Model_Components_Georef_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Virtualgeo_Model_Components_Georefproduct extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_georefproduct');
    }
    
    public function getValue4Product($productId)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()->where('product_id=?',$productId);
    	$res = array();
    	foreach ($collection->getItems() as $item)
    	{
    		$res[] = $item->getGeorefId();
    	}
    	 
    	return $res;
    }

}
