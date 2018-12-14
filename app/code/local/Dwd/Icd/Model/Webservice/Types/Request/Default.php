<?php
/**
 * <Namespace> <Module>
 * 
 * @property string 															  $arg0 Login
 * @property string|Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair $arg1 Passwort oder Wertepaar
 * @property string 															  $arg2 Parameter
 * @property Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair		  $arg3 Wertepaar
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	<Namespace>_<Module>_Block_<Submodule>
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013 - 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Webservice_Types_Request_Default
{
	public function __construct() {
		$args = func_get_args();
		
		if (isset($args[0]) && is_array($args[0]) && count($args) == 1) {
			$args = $args[0];
		}
		$c = count($args);
		
		if ($c > 2) {
			throw new Exception('Default class can only have two string parameters!');
		}
		for ($i = 0; $i < $c; $i++) {
			if (!isset($args[$i])) {
				continue;
			}
			if (!is_string($args[$i])) {
				throw new Exception('Default class can only have string parameters!');
			}
			$arg = "arg$i";
			$this->$arg = $args[$i];
		}
	}
} 