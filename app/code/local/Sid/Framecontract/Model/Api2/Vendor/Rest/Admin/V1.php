<?php
class Sid_Framecontract_Model_Api2_Vendor_Rest_Admin_V1 extends Sid_Framecontract_Model_Api2_Vendor
{
	
	
    protected function _retrieve()
    {
        $ident = intval($this->getRequest()->getParam('id'));
		$los = Mage::getModel('framecontract/vendor')->load($ident);
        return $los->getData();
    }
	
	
}