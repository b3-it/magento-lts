<?php
/**
 * Steuert die Startzeit für den AutoFileAssignment Dienst.
 *
 * @category   	Dwd
 * @package    	Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de 
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Backend_Cron extends Mage_Core_Model_Config_Data
{
	const CRON_STRING_PATH = 'crontab/jobs/dwdafa_autoassign_files/schedule/cron_expr';
 
	protected function _beforeSave() {
		$time = $this->getData('groups/dwd_afa/fields/runtime/value');
		$frequency = $this->getValue();
		
		$oldFrequency = Mage::getModel('core/config_data')
			->load($this->getId())
			->getValue()
		;
		
		$oldRuntime = Mage::getModel('core/config_data')
			->load('catalog/dwd_afa/runtime', 'path')
		;
		$oldRuntimeValue = $oldRuntime->getValue();
		
		$oldTime = explode(',', $oldRuntimeValue);
		if (is_array($oldTime) && count($oldTime) > 1 && count($oldTime) <= 3) {
			if ($frequency != $oldFrequency) {
				$diff = array_diff($time, $oldTime);
				if (empty($diff)) {
					$this->setValue(Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY);
					$oldRuntime->setValue('*,0')
						->save()
					;
					return parent::_beforeSave();
				}
			}
		}
		
		if (isset($time[0]) && strpos($time[0], '*/') === false && strpos($time[0], '*') === false && $frequency == Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY) {
			$this->setValue(Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_DAILY);
		} elseif (isset($time[0]) && strpos($time[0], '*') !== false && strpos($time[0], '*/') === false && $frequency != Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY) {
			$this->setValue(Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY);
		} elseif (isset($time[0]) && strpos($time[0], '*/') !== false && $frequency == Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY) {
			$this->setValue(Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_DAILY);
		}
		
		return parent::_beforeSave();
	}
	
    protected function _afterSave() {
        $time = $this->getData('groups/dwd_afa/fields/runtime/value');
 		$frequency = $this->getValue();
 		
        $cronDayOfWeek = date('N');
 
        if (isset($time[0]) && strpos($time[0], '*/') === false) {
        	$hour = intval($time[0]);
        } elseif (isset($time[0])){
        	$hour = (string) $time[0];
        } else {
        	$hour = 0;
        }
        
        $cronExprArray = array(
            intval($time[1]),                                   // Minute
            ($frequency == Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY) ? '*' : $hour,  // Hour
            ($frequency == Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY) ? '1' : '*',       // Day of the Month
            '*',                                                // Month of the Year
            ($frequency == Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY) ? '1' : '*',        // Day of the Week
        );
        $cronExprString = join(' ', $cronExprArray);
 
        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();
        } catch (Exception $e) {
            throw new Exception(Mage::helper('cron')->__('Unable to save the cron expression.'));
        }
        
        return parent::_afterSave();
    }
}
