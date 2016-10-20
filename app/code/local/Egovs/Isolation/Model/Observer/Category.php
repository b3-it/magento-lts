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
class Egovs_Isolation_Model_Observer_Category extends Egovs_Isolation_Model_Observer_Abstract
{
   
    public function onCategoryCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreRootCategories();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
	    	$collection = $observer->getCategoryCollection();
	    	
	    	$exp = new Zend_Db_Expr("substring_index(substring_index(path,'/',2),'/',-1) as root");
	    	$collection->getSelect()->columns($exp);
	    	
	    	$collection->getSelect()->having('root IN ('.$storeGroups.')')
	    ;
    	}
    	//die($collection->getSelect()->__toString());
    }
    
    public function onRootCategoryEdit($observer)
    {
    	$CategoryIds = $this->getUserStoreRootCategories();
    	if(($CategoryIds) && (count($CategoryIds) > 0)) 
    	{
    		foreach ($CategoryIds as $CategoryId)
    		{
    			//$store = Mage::getModel('core/store')->load($storeId);
    			//if($store->getRootCategoryId()!= 0)
    			{
    				$observer->getOptions()->setCategoryId($CategoryId);
    				return;
    			}
    		}
    	}
    }
  
    
}