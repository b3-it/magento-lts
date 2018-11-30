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
class Bkg_VirtualGeo_Model_Components_Contentcategory extends Mage_Core_Model_Abstract
{
	

	
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_contentcategory');
    }
    
   
    
    public function getCollectionAsOptions($productId,$storeId = 0)
    {
    	$res = array();
    	$collection = $this->getCollection();
    	
    	foreach($collection->getItems() as $item)
    	{
    		$res[] = array('label'=>$item->getName(),'value' => $item->getId());
    	}
    	 
    	return $res;
    }
}
