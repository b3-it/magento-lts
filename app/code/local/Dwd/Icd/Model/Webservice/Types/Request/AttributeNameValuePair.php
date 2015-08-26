<?php
/**
 * <Namespace> <Module>
 * 
 * @property string 															  $arg0 Login
 * @property Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair $arg1 Wertepaar
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	<Namespace>_<Module>_Block_<Submodule>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair
{
	public function Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair() {
		$args = func_get_args();
		
		if (isset($args[0]) && is_array($args[0]) && count($args) == 1) {
			$args = $args[0];
		}
		$c = count($args);
		
		for ($i = 0; $i < $c; $i++) {
			if (!isset($args[$i])) {
				continue;
			}
			if ($i == 1 && !($args[$i] instanceof Dwd_Icd_Model_Webservice_Types_AttributeNameValuePair)) {
				throw new Exception('Second parameter must be type of Dwd_Icd_Model_Webservice_Types_AttributeNameValuePair');
			}
			$arg = "arg$i";
			$this->$arg = $args[$i];
		}
	}
} 