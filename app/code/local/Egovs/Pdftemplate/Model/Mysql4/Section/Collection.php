<?php

class Egovs_Pdftemplate_Model_Mysql4_Section_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pdftemplate/section');
    }
    
    /**
     * Get Template by ID
     * 
     * @param int $id
     * 
     * @return array
     * @deprecated Use getByTemplateId
     */
	public function getByTempalteId($id) {
    	return $this->getByTemplateId($id);
    }
    
    /**
     * Get Template Sections by Template ID
     *
     * @param int $id
     *
     * @return array
     */
    public function getByTemplateId($id) {
    	$id = intval($id);
    	$this->getSelect()
    		->where('pdftemplate_template_id =?', intval($id))
    	;
    	 
    	$res = array();
    	foreach ($this->getItems()as $item) {
    		$res[$item->getSectiontype()] = $item;
    	}
    	 
    	return $res;
    }
}