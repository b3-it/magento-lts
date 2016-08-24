<?php
/**
 *  ExportOrder Helper
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_ExportOrder_Helper_Data extends Mage_Core_Helper_Abstract
{

	/**
	 *
	 * @param string $template Path
	 * @param array $recipient array(array('name'=>'Max','email'=>'max@xx.de'))
	 * @param array $data template Data
	 * @param number $storeid default 0
	 * @param array dateien die versendet werden sollen
	 * @return void|Sid_Framecontract_Helper_Data
	 */
	public function sendEmail($template, array $recipients, array $data = array(), $storeid = 0, $files = null)
	{
		$helper = Mage::helper('framecontract');
		$helper->sendEmail($template, $recipients, $data, $storeid, $files);
		return $this;
	}
}