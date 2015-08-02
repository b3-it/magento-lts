<?php

class Egovs_Extnewsletter_Model_Issue extends Mage_Core_Model_Abstract
{
	
	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'extnewsletter_issue';
	
	/**
	 * Parameter name in event
	 *
	 * In observe method you can use $observer->getEvent()->getObject() in this case
	 *
	 * @var string
	 */
	protected $_eventObject = 'extnewsletter_issue';
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/issue');
    }
    
    
    public function subscribeCustomersToIssue($customerIds, $issue_id)
    {
    	return $this->getResource()->subscribeCustomersToIssue($customerIds, $issue_id);
    }
    
    public function removeSubscriberFromIssue($queue_id, $subscriber_id)
    {
    	return $this->getResource()->removeSubscriberFromIssue($queue_id, $subscriber_id);
    }
    
}