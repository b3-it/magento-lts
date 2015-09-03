<?php
/**
 *  Persistenzklasse für Abomigration Collections
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Model_Mysql4_Abomigration_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('abomigration/abomigration');
    }
}