<?php
/**
 * Klasse für Rückmeldungen des ICD
 * 
 * @property string  $statusMessage Nachricht 
 * @property boolean $successStatus  Status
 * 
 * @category	Dwd
 * @package		Dwd_Icd
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 */
class Dwd_Icd_Model_Webservice_Types_Response_Default
{
	
	public function getReturn()
	{
		if (isset($this->return)) {
			return $this->return;
		}
		
		return null;
	}
}