<?php
/**
 * Merkzettel Model Config
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Config
{
	const XML_PATH_ORDER_STATES = 'global/sales/sidwishlist/states';

	public function getQuoteRuleConditionInstance($type) {
		$config = Mage::getConfig()->getNodeClassInstance("global/sales/quote/rule/conditions/$type");
		return $config;
	}

	public function getQuoteRuleActionInstance($type) {
		return Mage::getConfig()->getNodeClassInstance("global/sales/quote/rule/actions/$type");
	}

	/**
	 * Gibt Order-Status für den State zurück
	 *
	 * @param string $state State
	 * 
	 * @return array
	 */
	public function getOrderStatusesForState($state) {
		$states = Mage::getConfig()->getNode(self::XML_PATH_ORDER_STATES);
		if (!isset($states->$state) || !isset($states->$state->statuses)) {
			return array();
		}

		$statuses = array();

		foreach ($states->$state->statuses->children() as $status => $node) {
			$statuses[] = $status;
		}
		return $statuses;
	}
}
