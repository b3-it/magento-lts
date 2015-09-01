<?php
/**
 * Configurable Downloadable Products File resource model
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Resource_Link_File extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
     * Initialize connection and define resource
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/link_file', 'file_id');
    }
    
    /**
     * Prepare data for save
     *
     * @param Mage_Core_Model_Abstract $object Model
     *
     * @return array
     */
    protected function _prepareDataForSave(Mage_Core_Model_Abstract $object) {
    	$currentTime = Varien_Date::now();
    	if ((!$object->getId() || $object->isObjectNew()) && !$object->getCreatedAt()) {
    		$object->setCreatedAt($currentTime);
    	}
//     	$object->setUpdatedAt($currentTime);
    	$data = parent::_prepareDataForSave($object);
    	return $data;
    }
    
    /**
     * Lädt Link File über Dateinamen
     *
     * @param Dwd_ConfigurableDownloadable_Model_Link_File $linkFile     Datei
     * @param string 									   $linkFileName Datei-Name
     * 
     * @return Mage_Customer_Model_Resource_Customer
     */
    public function loadByFilename(Dwd_ConfigurableDownloadable_Model_Link_File $linkFile, $linkFileName) {
    	$adapter = $this->_getReadAdapter();
    	$bind    = array('link_file_name' => $linkFileName);
    	$select  = $adapter->select()
    		->from($this->getMainTable(), array($this->getIdFieldName()))
    		->where('link_file = :link_file_name')
    	;
    
    	$linkFileId = $adapter->fetchOne($select, $bind);
    	if ($linkFileId) {
    		$this->load($linkFile, $linkFileId);
    	} else {
    		$linkFile->setData(array());
    	}
    
    	return $this;
    }
}
