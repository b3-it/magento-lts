<?php
/**
 *  Persistenzklasse für Abomigration (Resource)
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Model_Mysql4_Abomigration extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the abomigration_id refers to the key field in your database table.
        $this->_init('abomigration/abomigration', 'abomigration_id');
    }
}