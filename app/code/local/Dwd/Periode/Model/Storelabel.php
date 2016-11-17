<?php

class Dwd_Periode_Model_Storelabel extends Mage_Core_Model_Abstract
{


    public function _construct()
    {
        parent::_construct();
        $this->_init('periode/storelabel');
    }

    public function loadByPeriode($periodeId, $storeid  = 0)
    {
    	$this->_beforeLoad(0, null);
    	$this->_getResource()->loadByPeriode($this, $periodeId, $storeid );
    	$this->_afterLoad();
    	$this->setOrigData();
    	$this->_hasDataChanges = false;
    	return $this;
    }
 
}