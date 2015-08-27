<?php
/**
 * AutoFileAssigner (AFA) Cron Exception 
 * 
 * Überschreibt __toString() um nur eine kurze Meldung auszugeben.
 *
 * @category	Dwd
 * @package		Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Cron_Exception extends Mage_Cron_Exception
{
	public function __toString() {
		return $this->getMessage();
	}
}
