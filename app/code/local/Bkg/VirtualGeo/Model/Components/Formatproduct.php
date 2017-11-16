<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Model_Components_Format_entity
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
    

    public function getValue4Product($productId)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()->where('product_id=?',$productId);
    	$res = array();
    	foreach ($collection->getItems() as $item)
    	{
    		$res[] = $item->getFormatId();
    	}
    
    	return $res;
    }
}
