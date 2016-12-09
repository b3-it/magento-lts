<?php
/**
 *  Persistenzklasse für Pendelliste (Resource)
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_Pendelliste_Model_Mysql4_Pendelliste extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pendelliste_id refers to the key field in your database table.
        $this->_init('pendelliste/pendelliste', 'id');
    }
    
    
    
    public function clear()
    {
    	$this->_getWriteAdapter()->delete($this->getTable('pendelliste/pendelliste'));
    	 
    }
}