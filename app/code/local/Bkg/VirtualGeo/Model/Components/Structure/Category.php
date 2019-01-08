<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Structure_Category
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Structure_Category extends Mage_Core_Model_Abstract
{

	
	public function _construct()
	{
		parent::_construct();
		$this->_init('virtualgeo/components_structure_category');
	}
	
	public function getOptionsArray()
	{
		$res = array();
		$collection = $this->getCollection();
		$res[0] = Mage::helper('virtualgeo')->__('All');
		foreach($collection->getItems() as $item)
		{
			$res[$item->getId()] = $item->getLabel();
		}
			
		return $res;
	}
}
