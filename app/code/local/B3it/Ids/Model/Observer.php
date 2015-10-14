<?php
/**
 * 
 *  Ids Observer
 *  @category B3It
 *  @package  B3it_Admin_Model_Observer
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2015 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Model_Observer
{
	public function onFrontControllerInitBefore($observer)
	{
		$front = $observer->getFront();
		$ids = Mage::getModel('b3it_ids/idsComponent');
		$ids->detect($front);
		
	}

}