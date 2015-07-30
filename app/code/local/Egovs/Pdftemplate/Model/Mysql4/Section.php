<?php

class Egovs_Pdftemplate_Model_Mysql4_Section extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pdftemplate_section_id refers to the key field in your database table.
        $this->_init('pdftemplate/section', 'pdftemplate_section_id');
    }
}