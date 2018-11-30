<?php

/**
 * Markerklasse
 * 
 * @category   	Egovs
 * @package    	Egovs_Extsalesorder
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Core_Helper_Abstract
 */
class Egovs_Extsalesorder_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Übersetzt den Header einer Grid Column
	 * 
	 * @param array $args
	 * 
	 * @return array
	 */
	public function translate($args) {
		if (array_key_exists('header', $args)) {
			$args['header'] = $this->__($args['header']);
		}
		
		return $args;
	}
	
	public function getBaseBalanceColumnParams()
	{
		return array(
				'header' => $this->__('Balance (Base)'),
				'index' => 'base_grand_total',
				'index_paid' => 'base_total_paid',
				'type' => 'currency',
				'renderer' => 'egovsbase/adminhtml_widget_grid_column_renderer_balance',
				'currency' => 'base_currency_code', 
				'filter_condition_callback' => array('Egovs_Extsalesorder_Helper_Data', 'filterbaseGrantTotalCondition'),
		);
	}
	
	public static function filterbaseGrantTotalCondition($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
	
		if (isset($value['from'])){
			$collection->getSelect()->where('(base_grand_total - ifnull(base_total_paid, 0))  >='.$value['from']*1);
		}
		if (isset($value['to'])){
			$collection->getSelect()->where('(base_grand_total - ifnull(base_total_paid, 0))  <='.$value['to']*1);
		}
	}
}