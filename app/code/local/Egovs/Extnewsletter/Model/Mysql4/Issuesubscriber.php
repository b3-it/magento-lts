<?php

class Egovs_Extnewsletter_Model_Mysql4_Issuesubscriber extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extnewsletter_id refers to the key field in your database table.
        $this->_init('extnewsletter/issuesubscriber', 'extnewsletter_issuesubscriber_id');
    }
    
    public function loadByIdAndIssue($subsciberId,$issueId)
    {
    	$read = $this->_getReadAdapter(); 
        $select = clone $read->select()
            ->from($this->getTable('extnewsletter/issuesubscriber'))
            ->where('subscriber_id=?',$subsciberId)
            ->where('issue_id=?',$issueId);

        $result = $read->fetchRow($select);

        if(!$result) {
            return array();
        }

        return $result;
    }
    
   public function resetIssuesBySubscriberId($subsciberId)
    {
    	$sql = "UPDATE ".$this->getTable("extnewsletter/issuesubscriber");
    	$sql .= " SET is_active=0 WHERE subscriber_id=".$subsciberId;
		$this->_getWriteAdapter()->query($sql);
		
    }
}