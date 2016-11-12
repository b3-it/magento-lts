<?php
class Sid_Framecontract_Model_Api2_Contract_Rest_Admin_V1 extends Sid_Framecontract_Model_Api2_Losinfo
{

	
    protected function _retrieve()
    {
       
        $ident = intval($this->getRequest()->getParam('id'));
		$los = Mage::getModel('framecontract/contract')->load($ident);
        return $los;
    }
	
	
}