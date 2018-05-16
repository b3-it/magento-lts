<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Email_Recipient
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getRecipientId()
 *  @method setRecipientId(int $value)
 *  @method int getMessageId()
 *  @method setMessageId(int $value)
 *  @method string getEmail()
 *  @method setEmail(string $value)
 *  @method string getPrefix()
 *  @method setPrefix(string $value)
 *  @method string getFirstname()
 *  @method setFirstname(string $value)
 *  @method string getLastname()
 *  @method setLastname(string $value)
 *  @method string getCompany()
 *  @method setCompany(string $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method  getProcessedAt()
 *  @method setProcessedAt( $value)
 *  @method string getErrorText()
 *  @method setErrorText(string $value)
 */
class B3it_Messagequeue_Model_Email_Recipient extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/email_recipient');
    }
}
