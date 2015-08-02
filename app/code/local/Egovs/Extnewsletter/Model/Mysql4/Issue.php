<?php

class Egovs_Extnewsletter_Model_Mysql4_Issue extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extnewsletter_id refers to the key field in your database table.
        $this->_init('extnewsletter/issue', 'extnewsletter_issue_id');
    }
    
    public function subscribeCustomersToIssue($customerIds, $issue_id)
    {
    	if(count($customerIds) > 0 )
    	{
    		$customerIds = implode(",", $customerIds);
    		$sql = "(SELECT subscriber_id, ".$issue_id .",true FROM ". $this->getTable('newsletter/subscriber')." WHERE customer_id IN (".$customerIds."))";
    		$sql = "INSERT INTO " .$this->getTable('extnewsletter/issuesubscriber')."(subscriber_id, issue_id,is_active) " . $sql;
    		//die($sql);
    		$stmt = $this->_getWriteAdapter()->query($sql);
    		return $stmt->rowCount();
    	}
    	
    	return 0;
    }
    
    
	public function removeSubscriberFromIssue($queue_id, $subscriber_id)
    {
    	if($queue_id && $subscriber_id)
    	{
    		/*
    		 * SELECT * FROM extnewsletter_issues_subscriber as sub
Join extnewsletter_issue as issue on issue.extnewsletter_issue_id = sub.issue_id and issue.remove_subscriber_after_send = 1
join extnewsletter_queue_issue as queue on queue.issue_id = issue.extnewsletter_issue_id and queue.queue_id = 1
where sub.subscriber_id = 1
    		 */
    		$sql = "DELETE sub FROM extnewsletter_issues_subscriber as sub
					Join extnewsletter_issue as issue on issue.extnewsletter_issue_id = sub.issue_id and issue.remove_subscriber_after_send = 1
					join extnewsletter_queue_issue as queue on queue.issue_id = issue.extnewsletter_issue_id and queue.queue_id = ".$queue_id. "
					where sub.subscriber_id = ".$subscriber_id;
    		$stmt = $this->_getWriteAdapter()->query($sql);
    	}
    	return $this;
    }
    
}