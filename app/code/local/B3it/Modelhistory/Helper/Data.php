<?php
/**
 * Helper
 * 
 * @category    B3it
 * @package        B3it_Modelhistory
 * @author        Hans Mackowiak <h.mackowiak@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class B3it_Modelhistory_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * 
     * 
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
    public function cleanupConfig($schedule) {
        $days = Mage::getStoreConfig('b3it_modelhistory/cron/config_delete_days');
        if (!$days) {
            return;
        }
        
        // sub 5 days
        $newDate = Mage::app()->getLocale()->date(null)->subDay(intval($days));
        
        $model = Mage::getModel('b3it_modelhistory/config');
        /**
         * @var B3it_Modelhistory_Model_Resource_Config_Collection $collection
         * @var B3it_Modelhistory_Model_Config $obj
         */
        $collection = $model->getCollection();
        $collection->addFieldToFilter('date', array('lt' => $newDate->toString('Y-M-d H:m:s')));

        foreach ($collection as $obj) {
            $obj->delete();
        }
    }

    /**
     * 
     * 
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
    public function cleanupModel($schedule) {
        $days = Mage::getStoreConfig('b3it_modelhistory/cron/model_delete_days');
        if (!$days) {
            return;
        }
        // sub 5 days
        $newDate = Mage::app()->getLocale()->date(null)->subDay(intval($days));
        
        $model = Mage::getModel('b3it_modelhistory/history');
        /**
         * @var B3it_Modelhistory_Model_Resource_History_Collection $collection
         * @var B3it_Modelhistory_Model_History $obj
         */
        $collection = $model->getCollection();
        $collection->addFieldToFilter('date', array('lt' => $newDate->toString('Y-M-d H:m:s')));

        foreach ($collection as $obj) {
            $obj->delete();
        }
    }
}