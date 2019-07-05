<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Resource_Queue_Ruleset_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Resource_Queue_Ruleset_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/queue_ruleset');
    }


    public function getModels4Categrory($category)
    {
        $this->getSelect()
            ->where('category=?',$category)
            ->where('status=?',B3it_Messagequeue_Model_Queue_Status::STATUS_ENABLED);

        return $this->getItems();
    }

}