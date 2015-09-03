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
class Dwd_Icd_Model_Webservice_Types_Response_LdapStatus
{
	
	public function getMessage()
	{
		if( isset($this->statusMessage))
		{
			return $this->statusMessage;
		}
		
		return '';
		
	}
	
	public function getStatus()
	{
		if( isset($this->successStatus))
		{
			return $this->successStatus;
		}
		
		return false;
	}
	
	public function getCode()
	{
		if( isset($this->code))
		{
			return $this->code;
		}
	
		return -1;
	}
	
}