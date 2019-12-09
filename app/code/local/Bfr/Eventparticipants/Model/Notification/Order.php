<?php
/**
 *
 * @category   	Bfr Eventparticipants
 * @package    	Bfr_Eventparticipants
 * @name       	Bfr_Eventparticipants_Model_Notification_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getQuoteItemId()
 *  @method setQuoteItemId(int $value)
 *  @method int getOrderItemId()
 *  @method setOrderItemId(int $value)
 *  @method int getCustomerId()
 *  @method setCustomerId(int $value)
 *  @method string getHash()
 *  @method setHash(string $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method int getEventId()
 *  @method setEventId(int $value)
 *  @method  getSignedAt()
 *  @method setSignedAt( $value)
 */
class Bfr_Eventparticipants_Model_Notification_Order extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bfr_eventparticipants/notification_order');
    }
}
