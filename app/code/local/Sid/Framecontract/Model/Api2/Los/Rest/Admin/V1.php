<?php
class Sid_Framecontract_Model_Api2_Los_Rest_Admin_V1 extends Sid_Framecontract_Model_Api2_Losinfo
{
	

    protected function _retrieve()
    {
       
        $ident = $this->getRequest()->getParam('ident');
		$los = Mage::getModel('framecontract/los')->load($ident,'key');
        return $los;
    }
	
	
}