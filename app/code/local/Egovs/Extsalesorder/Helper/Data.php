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
}