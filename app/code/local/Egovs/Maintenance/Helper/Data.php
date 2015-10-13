<?php
class Egovs_Maintenance_Helper_Data extends Mage_Core_Helper_Abstract {
	
	private static $CONST = array(
		"OfflineType"	=> array(
			array("value" => 0, "label" => 'No'),
			array("value" => 1, "label" => 'Yes'),
			array("value" => 2, "label" => 'Scheduled')
		)
	);
	
	public function getConstValues($id){

		$ret = self::$CONST[$id];
		
		if($id === "OfflineType"){
			foreach($ret as &$val) {
				$val["label"] = Mage::helper('egovs_maintenance')->__($val["label"]);
			}
		}

		return $ret;
	}
}
