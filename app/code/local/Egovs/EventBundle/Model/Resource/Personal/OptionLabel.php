<?php
/**
 * Egovs EventBundle
 *
 *
 * @category   	Egovs
 * @package    	Egovs_EventBundle
 * @name       	Egovs_EventBundle_Model_Resource_PersonalOptionLabel
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Resource_Personal_OptionLabel extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the eventbundle_personaloptionlabel_id refers to the key field in your database table.
        $this->_init('eventbundle/personal_options_label', 'id');
    }
    
    
    public function loadByStoreOption($object, $storeId,$optionId)
    {
    	$read = $this->_getReadAdapter();
    	if ($read) {
    		$select = new Zend_Db_Select($read);
    		$select->from(array('main_table' => $this->getTable('eventbundle/personal_options_label')));
    		$select->where('store_id IN (0,'. intval($storeId).')');
    		$select->where('option_id = '.intval($optionId));
    		$select->order('store_id DESC');
    		$data = $read->fetchAll($select);
			
    		
    		
    		if ($data)
    		{
    			$data = $this->getData4Store($data,$storeId);
    			$object->setData($data);
    		}
    		$object->setStoreId($storeId);
    		$object->setOptionId($optionId);
    	}
    	
    	return $object;
    }
    
    private function getData4Store($data,$storeId)
    {
    	foreach($data as $d)
    	{
    		if($d['store_id'] == $storeId){
    			return $d;
    		}
    	}
    	
    	return array_shift($data);
    }
   
}
