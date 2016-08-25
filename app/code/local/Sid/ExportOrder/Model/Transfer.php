<?php
/**
 * 
 *  Basisklasse für die Bestellübertragung
 *  @category Egovs
 *  @package  Sid_ExportOrder_Model_Transfer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_ExportOrder_Model_Transfer extends Mage_Core_Model_Abstract
{
	
	/**
	 * 
	 * @param unknown $type
	 * @return Sid_ExportOrder_Model_Transfer
	 */
	public static function getInstance($type)
	{
		if($type == 'post')
		{
			return Mage::getModel('exportorder/transfer_post');
		}

		return Mage::getModel('exportorder/transfer_email');
	}

	public abstract function send($content);
}
