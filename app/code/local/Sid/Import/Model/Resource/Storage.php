<?php
/**
 * Sid Import
 *
 *
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import_Model_Resource_Storage
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Model_Resource_Storage extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the import_storage_id refers to the key field in your database table.
        $this->_init('sidimport/storage', 'id');
    }
    
    public function clear($taskId = 0)
    {
    	if($taskId){
    		$this->_getWriteAdapter()->delete($this->getTable('sidimport/storage'),'task = '. intval($taskId));
    	}else{
    		$this->_getWriteAdapter()->delete($this->getTable('sidimport/storage'));
    	}
    	
    	
    }
}
