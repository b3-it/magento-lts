<?php
/**
 *  Persistenzklasse für Haushalt (Resource)
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Model_Mysql4_Order_Info extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the haushalt_id refers to the key field in your database table.
        $this->_init('sidhaushalt/order_info', 'id');
    }
}