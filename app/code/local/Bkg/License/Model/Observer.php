<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Observer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Observer 
{
   
	public function onBkgOrgunitIsUsed($observer)
	{
		$orgunit = $observer->getEvent()->getObject();
		$used_by = $observer->getEvent()->getUsedBy();
		
		$collection = Mage::getModel('bkg_license/copy')->getCollection();
		$collection->getSelect()->where('orgunit_id=?',intval($orgunit->getId()));
		$count = count($collection);
		if($count > 0)
		{
			$used_by->setData(Mage::helper('bkg_license')->__('License Copy'),$count);
		}
		
	}
}
