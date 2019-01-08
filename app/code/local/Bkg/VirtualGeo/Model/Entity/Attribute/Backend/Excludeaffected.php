<?php

class Bkg_VirtualGeo_Model_Entity_Attribute_Backend_Excludeaffected
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
	
	public function beforeSave($object)
	{
		$affected = $object->getExcludeaffected();
		if($affected){
			$object->setExcludeaffected(implode(';', $affected));
		}
		return $this;
	}
	
	/**
	 * After load method
	 *
	 * @param Varien_Object $object
	 * @return Mage_Eav_Model_Entity_Attribute_Backend_Abstract
	 */
	public function afterLoad($object)
	{
		$affected = $object->getExcludeaffected();
		if(strlen(trim($affected))>0){
			$object->setExcludeaffected(explode(';', $affected));
		}
	
		return $this;
	}
}
