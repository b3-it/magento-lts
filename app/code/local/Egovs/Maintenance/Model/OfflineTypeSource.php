<?php
class Egovs_Maintenance_Model_OfflineTypeSource {
	
	public function toOptionArray() {

		return Mage::helper('egovs_maintenance')->getConstValues('OfflineType');
	}
}
