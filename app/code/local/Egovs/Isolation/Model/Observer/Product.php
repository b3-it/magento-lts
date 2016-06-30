<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Product extends Egovs_Isolation_Model_Observer_Abstract
{
   
    public function onProductCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
	    	$collection = $observer->getCollection();
	    	$collection->getSelect()->where('store_group IN ('.$storeGroups.')');
	    	$s = $collection->getSelect()->__toString();
	    	//die($s);
	    ;
    	}
    	
    }
    
    
    public function onProductLoad($observer)
    {
    	$product = $observer->getProduct();
    	$storeGroups = $this->getUserStoreGroups();
    	$storeGroup = $product->getStoreGroup();
    	if(($storeGroup) &&($storeGroups) && (count($storeGroups) > 0))
    	{ 
	    	foreach ($storeGroups as $st)
	    	{
	    		if($st == $storeGroup)
	    		{
	    			return;
	    		}
	    	}
	    	$this->denied();
    	}
    	
    }
    
    public function onProductNew($observer)
    {
    	$product = $observer->getProduct();
    
    	$storeGroup = Mage::app()->getRequest()->getParam('store_group');
    	if($product && $storeGroup && ($product->getId() == null))
    	//if($product && $storeGroup)
    	{
    		$product->setStoreGroup($storeGroup);
    	}
    	
    }
    
    
    public function onProductEditLayout($observer)
    {
    	$block = $observer->getBlock();
    	$block->setTemplate('egovs/isolation/catalog/product/edit.phtml');
    }
}