<?php
/**
 * Erweitert die Kundengruppen um Regeln zur automatischen Zuordnung
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Group extends Mage_Core_Model_Abstract
{
	public function _construct() {
		parent::_construct();
		$this->_init('egovsvies/group');
	}
}