<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Model_Resource_Request
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Model_Resource_Request extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the eventrequest_request_id refers to the key field in your database table.
        $this->_init('eventrequest/request', 'eventrequest_request_id');
    }
}
