<?php
class Egovs_Extnewsletter_Model_Issuesubscriber extends Mage_Core_Model_Abstract
{

 	public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/issuesubscriber');
    }
    
    public function loadByIdAndIssue($subsciberId,$issueId)
    {
    	$this->addData($this->getResource()->loadByIdAndIssue($subsciberId,$issueId));
        return $this;
    }
}