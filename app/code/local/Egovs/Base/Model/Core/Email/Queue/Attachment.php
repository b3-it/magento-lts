<?php
/**
 *  Speichern von Mail Attachments in der Queue
 *  
 *  @category Egovs
 *  @package  Egovs_Base
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Core_Email_Queue_Attachment extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('egovsbase/core_email_queue_attachment');
    }
}