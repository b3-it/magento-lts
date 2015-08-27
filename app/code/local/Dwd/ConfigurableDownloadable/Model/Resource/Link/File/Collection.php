<?php
/**
 * Configurable Downloadable Products resource Collection
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Resource_Link_File_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init resource model
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/link_file');
    }
    
	/**
     * Massenspeichern für NumberInUse Feld
     * 
     * @param array $aNumInUse Anzahl in Nutzung
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function massSaveNumberInUse($aNumInUse = array()) {
    	$numberInUseClasses = array();
    	
    	//Items in Klassen aufteilen
        foreach ($this->getItems() as $item) {
        	if (isset($aNumInUse[$item->getId()])) {
        		$item->decrease($aNumInUse[$item->getId()]);
        	}        	
        	
            if (array_key_exists($item->getNumberInUse(), $numberInUseClasses)) {
            	$numberInUseClasses[$item->getNumberInUse()][] = $item->getId();
            } else {
            	$numberInUseClasses[$item->getNumberInUse()] = array ($item->getId());
            }
            
            if ($item->getNumberInUse() < 1 && isset($this->_items[$item->getId()])) {
            	$item->deleteFile();
            	unset($this->_items[$item->getId()]);
            }
        }
        foreach ($numberInUseClasses as $class => $ids) {
        	$where = array('file_id in (?)' => $ids);
        	$table = $this->getMainTable();
        	if (!$table) {
        		$table = $this->getTable('configdownloadable/link_file');
        	}
        	if ($class < 1) {      		
        		$this->getConnection()->delete($table, $where);
        		continue;
        	}
        	
        	$this->getConnection()->update($table, array('number_in_use' => $class), $where);
        }
        return $this;
    }
}
