<?php
class B3it_Modelhistory_Model_History extends Mage_Core_Model_Abstract 
{
    protected function _construct()
    {
        $this->_init('b3it_modelhistory/history');
    }
    /**
     * 
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
    public function cleanup($schedule)
    {
        Mage::helper('b3it_modelhistory')->cleanupModel($schedule);
    }
}