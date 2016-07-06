<?php
/**
 *  Persitenzmodel für Anhänge in EmailQueue
 *  
 *  @category Egovs
 *  @package  Egovs_Base
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 - 2016 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Resource_Core_Email_Queue_Attachment extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the doc_id refers to the key field in your database table.
        $this->_init('egovsbase/mail_attachment', 'att_id');
    }
    
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
    	$bin = bin2hex($object->getBody());
    	$object->setBody($bin);
    	return parent::_beforeSave($object);
    }
    
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
    	$bin = hex2bin($object->getBody());
    	$object->setBody($bin);
    	return parent::_afterLoad($object);
    }
}