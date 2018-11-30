<?php
 /**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer_Model_Resource_Service_Service
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Viewer_Model_Resource_Service_Vggroup extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bkgviewer/service_vg_group', 'id');
    }
    
    
    /**
     * Laden einer Gruppe von Verwaltungsgebieten anhand der ident und CRS
     * @param Mage_Core_Model_Abstract $object
     * @param string $ident
     * @param string $crs
     * @return Bkg_Viewer_Model_Resource_Service_Vggroup
     */
    public function loadWithCRS(Mage_Core_Model_Abstract $object, $ident, $crs = null)
    {
    	$read = $this->_getReadAdapter();
    	if ($read && !is_null($ident)) {
    		
    		$select = $read->select()
    		->from($this->getMainTable())
    		->where('ident=?', $ident);
    		
    		if($crs){
    			$select->where('crs=?', $crs);
    		}
    		
    		$data = $read->fetchRow($select);
    
    		if ($data) {
    			$object->setData($data);
    		}
    	}
    
    	$this->unserializeFields($object);
    	$this->_afterLoad($object);
    
    	return $this;
    }
    
}
