<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getEventProducts()
	{
		$collection = Mage::getModel('catalog/product')->getCollection()
		->addAttributeToSelect('sku')
		->addAttributeToSelect('name')
		->addAttributeToFilter('type_id',Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
		
		return $collection;
	}

	public function getSignaturePath()
    {
        return  Mage::getBaseDir('var') . DS . 'signature';
    }
		
}