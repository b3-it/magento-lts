<?php
class B3it_Maintenance_Model_OfflineTypeSource {
	
	public function toOptionArray() {

		return Mage::helper('b3it_maintenance')->getConstValues('OfflineType');
	}
}
