<?php
/**
 * 
 *  Basisklase für die Formatierung der Bestellung
 *  @category Egovs
 *  @package  Sid_ExportOrder_Model_Format
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_ExportOrder_Model_Format extends Mage_Core_Model_Abstract
{
	/**
	 * 
	 * @param unknown $type
	 * @return Sid_ExportOrder_Model_Format
	 */
	public static function getInstance($type)
	{
		if($type == 'transdoc')
		{
			return Mage::getModel('exportorder/format_transdoc');
		}
	
		return Mage::getModel('exportorder/format_plain');;
	}
	
	public abstract function processOrder($order);
    
}
