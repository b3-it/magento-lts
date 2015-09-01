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
class Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Source_Cron_Frequency extends Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency
{
	const CRON_HOURLY  = 'H';
	
	protected $_cronOptions;
	
	public function toOptionArray() {
		if (!$this->_cronOptions) {
			$this->_cronOptions = parent::toOptionArray();
			$this->_cronOptions = array_reverse($this->_cronOptions);
			array_push(
				$this->_cronOptions,
				array(
					'label' => Mage::helper('cron')->__('Hourly'),
					'value' => self::CRON_HOURLY,
				)
			);
			$this->_cronOptions = array_reverse($this->_cronOptions);
		}
		return $this->_cronOptions;
	}
}