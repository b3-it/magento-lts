<?php
/**
 *  Persistenzklasse für ConfigCompare (Resource)
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Model_Mysql4_ConfigCompare extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the configcompare_id refers to the key field in your database table.
        $this->_init('configcompare/configcompare', 'configcompare_id');
    }
    
    public function deleteAll()
    {
    	$this->_getWriteAdapter()->delete(
    			$this->getMainTable()
    			);

    	return $this;
    }
}