<?php
 /**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Model_Resource_Components_Structureentity
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_VirtualGeo_Model_Resource_Components_Structureproduct extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('virtualgeo/components_structure_product', 'id');
    }
    
 
    public function saveDefault($defaultId, $productId, $storeId)
    {
    	$table = $this->getMainTable();
    	$data=array();
    	$data['is_default'] = '0';
    	$this->_getWriteAdapter()->update($table,$data, "product_id= $productId  AND store_id = $storeId ");
    	 

    	$data['is_default'] = '1';
    	if($defaultId){
    		$this->_getWriteAdapter()->update($table, $data, "product_id= $productId  AND store_id = $storeId AND structure_id = $defaultId ");
    	}
    
    	return $this;
    }
 
}
