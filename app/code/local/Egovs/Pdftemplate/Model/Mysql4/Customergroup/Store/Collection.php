<?php

class Egovs_Pdftemplate_Model_Mysql4_Customergroup_Store_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pdftemplate/customergroup_store');
    }
}