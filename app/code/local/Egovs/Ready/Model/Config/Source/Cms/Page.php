<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category		Egovs
 * @package			Egovs_Ready
 * @name			Egovs_Ready_Model_Config_Source_Cms_Page
 * @author			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright		Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license			http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Ready_Model_Config_Source_Cms_Page {
	public function toOptionArray() {
		$res = array();
		$collection = Mage::getModel('cms/page')->getCollection();
		$collection->distinct('identifier');
		$collection->load();
		$res[] = array('value' => '', 'label' => Mage::helper('egovsready')->__('No custom info'));
		foreach($collection->getItems() as $item) {
			$res[] = array('value'=>$item->getData('identifier'), 'label'=>$item->getData('identifier'));
		}
		 
		return $res;
	}
}