<?php
/**
 * ResourceModel: Kostenstelle
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Costunit extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Initialisierung mit eigenem Resource Model
	 *
	 * @return void
	 *
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {		 
		$this->_init('sales/order_item', 'item_id');
	}

	 /**
     * Ermittelt die Gesamtanzahl
     *
     * @param Mage_Adminhtml_Block_Report_Grid $grid Grid
     * @param string                           $from Von Datum
     * @param string                           $to   Bis Datum
     * 
     * @return Varien_Object
     */
	public function countTotals($grid, $from, $to)
	{
		$columns = array();
		foreach ($grid->getColumns() as $col) {
			$columns[$col->getIndex()] = array("total" => $col->getTotal(), "value" => 0);
		}

		$count = 0;
		$report = $grid->getCollection()->getReportFull($from, $to);
		foreach ($report as $item) {
			if ($grid->getSubReportSize() && $count >= $grid->getSubReportSize()) {
				continue;
			}
			$data = $item->getData();

			foreach ($columns as $field=>$a) {
				if ($field !== '') {
					$columns[$field]['value'] = $columns[$field]['value'] + (isset($data[$field]) ? $data[$field] : 0);
				}
			}
			$count++;
		}
		$data = array();
		foreach ($columns as $field => $a) {
			if ($a['total'] == 'avg') {
				if ($field !== '') {
					if ($count != 0) {
						$data[$field] = $a['value']/$count;
					} else {
						$data[$field] = 0;
					}
				}
			} elseif ($a['total'] == 'sum') {
				if ($field !== '') {
					$data[$field] = $a['value'];
				}
			} elseif (strpos($a['total'], '/') !== false) {
				if ($field !== '') {
					$data[$field] = 0;
				}
			}
		}

		$totals = new Varien_Object();
		$totals->setData($data);

		return $totals;
	}
}
