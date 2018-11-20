<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Queue_Message
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
*  @method int getId()
*  @method setId(int $value)
*  @method int getRulesetId()
*  @method setRulesetId(int $value)
*  @method int getOwnerId()
*  @method setOwnerId(int $value)
*  @method string getContent()
*  @method setContent(string $value)
*  @method string getRecipients()
*  @method setRecipients(string $value)
*  @method  getCreatedAt()
*  @method setCreatedAt( $value)
*  @method string getEvent()
*  @method setEvent(string $value)
*  @method string getCategory()
*  @method setCategory(string $value)
*  @method  getProcessedAt()
*  @method setProcessedAt( $value)
*  @method string getTransfer()
*  @method setTransfer(string $value)
*  @method string getFormat()
*  @method setFormat(string $value)
*  @method int getStatus()
*  @method setStatus(int $value)
*  @method int getStoreId()
*  @method setStoreId(int $value)
*  @method string getContentHtml()
*  @method setContentHtml(string $value)
*  @method string getB3itMqQueueMessagecol()
*  @method setB3itMqQueueMessagecol(string $value)
*/
class B3it_Messagequeue_Model_Queue_Message extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/queue_message');
    }
}
