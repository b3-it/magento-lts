<?php
/**
 * Egovs EventBundle
 *
 *
 * @category   	Egovs
 * @package    	Egovs_EventBundle
 * @name       	Egovs_EventBundle_Model_Resource_PersonalOption_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Resource_Personal_Option_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	private $store_id = 0;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventbundle/personal_option');
    }
    
    public function getStoreId()
    {
    	return $this->store_id;
    }
    
    public function setStoreId($value)
    {
    	$this->store_id = $value;
    }
    
    protected function _afterLoad()
    {
    	foreach($this->getItems() as $item)
    	{
    		$item->setStoreId($this->getStoreId());
    	}
    	
    	return parent::_afterLoad();
    }
    
}
