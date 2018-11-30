<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Agreement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Master_Abstract extends Mage_Core_Model_Abstract
{
	public function createCopy()
	{
		$resourceName = $this->_resourceName;
		
		$resourceName = str_replace('master', 'copy', $resourceName);
		
		$copy = Mage::getModel($resourceName);
		$data = $this->getData();
		
		unset($data['id']);
		 
		$copy->setData($data);
		
		return $copy;
	}
}
