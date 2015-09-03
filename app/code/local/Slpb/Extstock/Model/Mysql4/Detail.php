<?php

class Slpb_Extstock_Model_Mysql4_Detail extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
       $this->_init('extstock/journal', 'journal_id');
    }
    

    
   
}