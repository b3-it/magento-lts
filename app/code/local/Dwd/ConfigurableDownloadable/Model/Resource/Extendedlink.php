<?php
/**
 * Configurable Downloadable Products Extended Links Resource model
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink extends Mage_Downloadable_Model_Resource_Link
{
	/**
     * Initialize connection and define resource
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('downloadable/link', 'link_id');
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
    	$object->setUpdatedAt($currentTime);
    	$data = parent::_prepareDataForSave($object);
    	return $data;
    }
    
    /**
     * Delete data by item(s)
     *
     * @param Mage_Downloadable_Model_Link|array|int $items Items
     * 
     * @return Mage_Downloadable_Model_Resource_Link
     */
    public function deleteItems($items) {
    	if (is_array($items) && isset($items['delete'])) {
    		parent::deleteItems($items['delete']);
    		
    		if (isset($items['links'])) {
    			/* @var $collection Dwd_ConfigurableDownloadable_Model_Resource_Link_File_Collection */
    			$model = Mage::getModel('configdownloadable/link_file');
    			$collection = $model->getCollection();
    			$fileLinkIds = array_keys($items['links']);
    			$idFieldName = $collection->getIdFieldName();
    			if (!$idFieldName) {
    				$idFieldName = $model->getIdFieldName();	
    			}
    			$collection->addFieldToFilter($idFieldName, array("in" => $fileLinkIds));
    			$collection->massSaveNumberInUse($items['links']);
    		}
    	} else {
    		$linkFileItems = array();
    		if (is_array($items)) {
	    		$adapter    = $this->_getReadAdapter();
	    		$select = $adapter->select()
		            ->from(array($this->getMainTable()), array('link_file_id'))
// 		            ->where($adapter->prepareSqlCondition('link_id', array('in' => $items)))
	    			->where("{$adapter->quoteIdentifier('link_id')} in (?)", $items)
		            ->where($adapter->prepareSqlCondition($adapter->quoteIdentifier('link_file_id'), array('notnull' => true)))
		        ;
	    		//bind geht mit array nicht!! --> Ursache unbekannt...
		        /* $bind = array(
		            	'link_ids'   => $items,
		        ); */
		        $itemsToDelete = $adapter->fetchAll($select);
		        
		        foreach ($itemsToDelete as $item) {
		        	if (!isset($item['link_file_id'])) {
		        		continue;
		        	}
		        	if (array_key_exists($item['link_file_id'], $linkFileItems)) {
		        		$linkFileItems[$item['link_file_id']] = $linkFileItems[$item['link_file_id']] + 1;
		        	} else {
		        		$linkFileItems[$item['link_file_id']] = 1;
		        	}
		        }
    		} elseif ($items instanceof Mage_Downloadable_Model_Link) {
    			$linkFileItems[$items->getId()] = 1;
    		}
    		parent::deleteItems($items);
    		if (!empty($linkFileItems)) {
    			/* @var $collection Dwd_ConfigurableDownloadable_Model_Resource_Link_File_Collection */
    			$model = Mage::getModel('configdownloadable/link_file');
    			$collection = $model->getCollection();
    			$fileLinkIds = array_keys($linkFileItems);
    			$idFieldName = $collection->getIdFieldName();
    			if (!$idFieldName) {
    				$idFieldName = $model->getIdFieldName();
    			}
    			$collection->addFieldToFilter($idFieldName, array("in" => $fileLinkIds));
    			$collection->massSaveNumberInUse($linkFileItems);
    		}
    	}
    	
    	return $this;
    }
}
