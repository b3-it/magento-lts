<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Resource_Service_Service_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Model_Resource_Service_vggroup_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/service_vggroup');
    }
    
    public function getAsFormOptions($appendEmpty = false)
    {
    	$res = array();
    	if($appendEmpty){
    		$res[0] = Mage::helper('bkgviewer')->__('-- please Select --');
    	}
    	foreach ($this->getItems() as $item)
    	{
    		$res[$item->getIdent()] = $item->getIdent();
    	}
    	 
    	return $res;
    }
}
