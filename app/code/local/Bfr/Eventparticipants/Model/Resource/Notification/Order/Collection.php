<?php
/**
 *
 * @category   	Bfr Eventparticipants
 * @package    	Bfr_Eventparticipants
 * @name       	Bfr_Eventparticipants_Model_Resource_Notification_Order_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Model_Resource_Notification_Order_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bfr_eventparticipants/notification_order');
    }
}
