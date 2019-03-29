<?php

class Egovs_Base_Model_Customer_LastOrder extends Mage_Core_Model_Abstract
{
	

	
    public function _construct()
    {
        parent::_construct();
        $this->_init('egovsbase/customer_lastOrder');
    }


}
