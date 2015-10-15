<?php
/**
 * <Namespace> <Module>
 *
 * @property string $name  Name des Parameters
 * @property string $value Wert des Parameters
 *
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	<Namespace>_<Module>_Block_<Submodule>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Webservice_Types_AttributeNameValuePair
{
	/**
	 * Konstruktor
	 * 
	 * @param string $name  Name des Parameters
	 * @param string $value Wert des Parameters
	 */
	public function xxDwd_Icd_Model_Webservice_Types_AttributeNameValuePair($name, $value) {
		$this->name = $name;
		$this->value = $value;
	}
	
	public function Dwd_Icd_Model_Webservice_Types_AttributeNameValuePair() {
		if($v = func_get_args(0)){
			$this->name = $v;
		} else{
			$this->name = "";
		}
			
		if($v = func_get_args(1)){
			$this->value = $v;
		} else{
			$this->value = "";
		}
		
	}
}