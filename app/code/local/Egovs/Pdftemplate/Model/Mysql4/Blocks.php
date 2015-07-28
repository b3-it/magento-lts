<?php

class Egovs_Pdftemplate_Model_Mysql4_Blocks extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pdftemplate_blocks_id refers to the key field in your database table.
        $this->_init('pdftemplate/blocks', 'pdftemplate_blocks_id');
    }
}