<?php
/**
 * 
 *  Liste aller ConfigVirtual Produkte 
 *  @category Dwd
 *  @package  Dwd_Abomigration_Model_System_Config_Source_Products
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Dwd_Abomigration_Model_System_Config_Source_Products 
{
	/**
	 * Retrieve all options array
	 *
	 * @return array
	 */
	public function toOptionHashArray()
    {
    	/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
    	$collection = Mage::getModel('catalog/product')->getCollection();
    	$collection->addAttributeToFilter('type_id',Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL);
    	$collection->addAttributeToSelect('name');
    	$res = array();
    	foreach($collection->getItems() as $item)
    	{
    		$res[] = array('value'=> $item->getId(),'label' => $item->getSku().' ' . $item->getName());
    	}
        return $res;
    }
	
    
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function toOptionArray()
    {
    	/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
    	$collection = Mage::getModel('catalog/product')->getCollection();
    	$collection->addAttributeToFilter('type_id',Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL);
    	$collection->addAttributeToSelect('name');
    	$res = array();
    	foreach($collection->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getSku();
    	}
    	return $res;
    }
}