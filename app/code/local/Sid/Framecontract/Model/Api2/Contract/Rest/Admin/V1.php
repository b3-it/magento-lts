<?php
class Sid_Framecontract_Model_Api2_Contract_Rest_Admin_V1 extends Sid_Framecontract_Model_Api2_Losinfo
{

	
    protected function _retrieve()
    {
       
        $ident = intval($this->getRequest()->getParam('id'));
		$model = Mage::getModel('framecontract/contract')->load($ident);
		
		$storeid = $model->getStoreId();
		
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("framecontract/email/sender_name", $storeid);
		$sender['email'] = Mage::getStoreConfig("framecontract/email/sender_email_address", $storeid);
		
		
		if(strlen($sender['name']) < 2 ){
			$sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeid);
		}
		
		if(strlen($sender['email']) < 2 ){
			$sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeid);
		}
		
		$model->setContractManager($sender);
		
        return $model;
    }
	
	
}