<?php
/**
 *  Gka_InternalPayId_Helper_Data
 *  @category Gka
 *  @package  Gka_InternalPayId
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Gka_InternalPayId_Helper_Data extends Mage_Core_Helper_Abstract
{
	public static function parseFloat($str) {
		$str = preg_replace('[^0-9\,\.\-\+]', '', strval($str));
		$str = strtr($str, ',', '.');
		$pos = strrpos($str, '.');
		return ($pos===false ? floatval($str) : floatval(str_replace('.', '', substr($str, 0, $pos)) . substr($str, $pos)));
	}
}