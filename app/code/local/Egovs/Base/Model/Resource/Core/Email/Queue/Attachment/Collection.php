<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Resource_Core_Email_Queue_Attachment_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('egovsbase/core_email_queue_attachment');
    }
    
    
    protected function _afterLoadData()
    {
    	foreach($this->getItems() as $item)
    	{
    		$item->afterLoad();
    	}
    	return parent::_afterLoadData();
    }
}