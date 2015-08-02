<?php

class Egovs_Extnewsletter_Model_Mysql4_Queueissue extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extnewsletter_id refers to the key field in your database table.
        $this->_init('extnewsletter/issuequeue', 'extnewsletter_queue_issue_id');
    }
    
    /*
     * zum Merken der Einstellungen fuer einen erneuten Formularaufruf
     */
    public function saveIssueQueue($queueId)
    {
    		
		$issues = Mage::app()->getRequest()->getPost('news_for_issues');
		$this->_deletePrevious($queueId);

		if($issues != null)
		{
			foreach( $issues as $issue)
			{
				$queue= Mage::getModel('extnewsletter/queueissue');
				$queue->setData('issue_id',$issue);
				$queue->setData('queue_id',$queueId);
				$queue->save();
			}
		}
		
		return $this;
    }
 
	private function _deletePrevious($queueid)
	{
		$resource = Mage::getSingleton('core/resource');
		$conn= $resource->getConnection('core_write');
		$extTable = $resource->getTableName('extnewsletter_queue_issue');
		
		$sql = "DELETE FROM " .$extTable ." WHERE queue_id=".$queueid;
		$result = $conn->query($sql);
		
	}
}