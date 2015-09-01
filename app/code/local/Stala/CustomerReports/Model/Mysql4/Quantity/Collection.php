<?php
/**
 * Verkaufte (Shipped) Produkte reports ResourceCollection
 *
 * @category   Stala
 * @package    Stala_CustomerReports
 * @author     Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @see Egovs_Extreport_Model_Mysql4_Product_Stockflow_Collection
 */
class Stala_CustomerReports_Model_Mysql4_Quantity_Collection extends Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
{
	/**
	 * Muss für Kundengruppenunterstützung überschrieben werden
	 * 
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 * 
	 * @return Stala_CustomerReports_Model_Mysql4_Quantity_Collection
	 */
	protected function _addSalesQuantity($from, $to) {
		parent::_addSalesQuantity($from, $to);

		//20110329, F. Rochlitzer
		//Kundengruppenunterstützung
		//################################################################################################################################
		$this->getSelect()
			->joinLeft(array('customer'=>$this->getTable('customer/entity')), 'customer.entity_id = customer_id', array("group_id"))
		;

		//Gäste haben keine customer id (null)
		$groupId = Mage::registry('cgroup');
		if (isset($groupId)) {
			$this->getSelect()->group('group_id');
			 
			$cmp = '=';
			 
			if ($groupId <= 0) {
				$groupId = "NULL";
				$cmp = "is";
			}
			$this->getSelect()->where("group_id $cmp $groupId");
		}
		//################################################################################################################################

		return $this;
	}
}
