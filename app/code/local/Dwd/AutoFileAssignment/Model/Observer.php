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
		$lifetimes = Mage::getConfig()->getStoresConfigByPath('catalog/dwd_afa/runtime');
		$_shouldRun = false;
		$_msg = null;
		
		foreach ($lifetimes as $storeId=>$lifetime) {
			//Admin ignorieren
			if ($storeId == 0) {
				continue;
			}
			
			/* @var $collection Mage_Cron_Model_Resource_Schedule_Collection */
			$collection = $schedule->getCollection();
			$collection->addFieldToFilter('job_code', $schedule->getJobCode())
				->addFieldToFilter($schedule->getIdFieldName(), array('neq' => $schedule->getId()))
				->addFieldToSelect('status')
				//Bind wird von Select wird von Bind der DataCollection überschrieben
				->addBindParam('status_run', Mage_Cron_Model_Schedule::STATUS_RUNNING)
				->getSelect()->where('status = :status_run')
			;
			//Mage::log('dwdafa::Service SQL:'.$collection->getSelect()->__toString() . " lastrun " .date("Y-m-d H:i:s", time()-$lifetime-$offset), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
			if ($collection->count() > 0) {
				$message = Mage::helper('dwdafa')->__('AFA service is still running');
				Mage::helper('dwdafa')->sendMailToAdmin("dwdafa::".$message);
				Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
				$_msg = $message;
			} else {
				$_shouldRun = true;
			}
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