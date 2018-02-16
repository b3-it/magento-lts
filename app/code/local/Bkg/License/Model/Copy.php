<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Copy_Entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy extends Bkg_License_Model_Textprocess
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/copy');
    }
    
    protected function _saveRelated($collection)
    {
    	if($collection != null){
    		foreach($collection as $item){
    			$item->setCopyId($this->getId());
    			$item->save();
    		}
    	}
    }
    
    /**
     *
     * @param unknown $resourceName
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _getRelated($resourceName)
    {
    	$collection = Mage::getModel($resourceName)->getCollection();
    	$collection->getSelect()->where('copy_id=?',intval($this->getId()));
    	 
    	return $collection->getItems();
    }
    
    
    public function processTemplate()
    {
    	$this->setContent($this->_replaceVariables($this->getTemplate()));
    	return $this;
    }
		
	
    
}
