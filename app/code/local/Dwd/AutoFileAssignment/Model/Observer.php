<?php
/**
 * AutoFileAssigner (AFA) Observer dient zur automatischen Zuweisung von Dateien zu ausgewählten Produkten.
 *
 * @category	Dwd
 * @package		Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Model_Observer extends Varien_Object
{
	/**
	 * Clean expired dynamic generated links
	 *
	 * @param Mage_Cron_Model_Schedule $schedule Schedule
	 * 
	 * @return Dwd_AutoFileAssignment_Model_Observer
	 */
	public function cleanExpiredDynamicLinks($schedule) {
		Mage::dispatchEvent('clear_expired_dynamic_links_before', array('dwdafa_observer' => $this));
		
		Mage::helper('dwdafa')->cleanExpiredDynamicLinks($this);
		
		return $this;
	}
	
	/**
	 * Auto-Zuweisung von Dateien zu Links
	 *
	 * @param Mage_Cron_Model_Schedule $schedule Schedule
	 *
	 * @return Dwd_AutoFileAssignment_Model_Observer
	 */
	public function autoAssignFiles($schedule) {
		$_shouldRun = false;
		$_msg = null;

        $lockKey = 'dwd_afa_apr_cron_mutex' . $schedule->getId();

        // TODO TTL muss dynamisch errechnet werden --> jetzt statisch auf 10 Min
        // Sollte über schedule collection next runtime möglich sein
        $ttl = 600;
        $lockResult = Mage::helper('egovsbase/lock')->getLock($lockKey, $ttl);
        if ($lockResult === null) {
            Mage::log("dwd_afa::apr:LOCK $lockKey couldn't be obtained!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            throw new Dwd_AutoFileAssignment_Cron_Exception("LOCK $lockKey couldn't be obtained!");
        }

        if ($lockResult == 0) {
            Mage::log("dwd_afa::apr:LOCK $lockKey already called, omitting!", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
            return true;
        }

        $lastRun = date("Y-m-d H:i:s", (time() - ($ttl)));
        $statusRun = Mage_Cron_Model_Schedule::STATUS_RUNNING;

        $collection = $schedule->getCollection();
        $collection->addFieldToFilter('job_code', $schedule->getJobCode())
            ->addFieldToFilter($schedule->getIdFieldName(), array('neq' => $schedule->getId()))
            ->addFieldToSelect('status')
            ->getSelect()->where("(executed_at >'" . $lastRun . "'  AND status = '" . $statusRun . "')");

        if ($collection->count() > 0) {
            $_msg = Mage::helper('dwdafa')->__('Service is still running');
            Mage::log($_msg, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
            Mage::helper('egovsbase/lock')->releaseLock($lockKey);
        } else {
            $_shouldRun = true;
        }
		
		if ($_shouldRun) {
			try {
				Mage::log(Mage::helper('dwdafa')->__('AFA service started'), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
				Mage::helper('dwdafa')->runAfa();
				Mage::log(Mage::helper('dwdafa')->__('AFA service finished'), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
			} catch (Dwd_AutoFileAssignment_Exception $dafae) {
				//Dwd_AutoFileAssignment_Exception werden schon geloggt
				Mage::log(Mage::helper('dwdafa')->__($dafae->getMessage()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			} catch (Exception $e) {
				Mage::logException($e);
				Mage::log(Mage::helper('dwdafa')->__('There was an runtime error for the AFA service. Please check your log files.'), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			}
		} else {
			throw new Dwd_AutoFileAssignment_Cron_Exception($_msg);
		}
	
		return $this;
	}
}