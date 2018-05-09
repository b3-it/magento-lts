<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Queue_Ruleset
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Ruleset extends Mage_Core_Model_Abstract
{
	protected $_rules = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/queue_ruleset');
    }
    
    public function getRules()
    {
    	if($this->_rules == null)
    	{
    		$collection = Mage::getModel('b3it_mq/queue_rule')->getCollection();
    		$collection->getSelect()->where('ruleset_id =?',intval($this->getId()));
    		$this->_rules= $collection->getItems();
    	}
    	
    	return $this->_rules;
    
    }
}
