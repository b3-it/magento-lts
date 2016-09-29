<?php
/**
 * Sid ExportOrder
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Model_Resource_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Resource_Order extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the exportorder_order_id refers to the key field in your database table.
        $this->_init('exportorder/order', 'id');
    }
    
    
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
    	$object->setSemaphor($this->getSemaphor());
    	return parent::_beforeSave($object);
    }
    
    
    protected function getSemaphor()
    {
    	return Mage::helper('exportorder')->getSemaphor();
    }
    
}
